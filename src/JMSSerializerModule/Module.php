<?php

/*
 * This file is part of the JMSSerializerModule package.
 *
 * (c) Martin Parsiegla <martin.parsiegla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JMSSerializerModule;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Annotations\IndexedReader;
use JMS\Serializer\Handler\DateHandler;
use JMS\Serializer\JsonDeserializationVisitor;
use JMS\Serializer\JsonSerializationVisitor;
use JMS\Serializer\Metadata\Driver\AnnotationDriver;
use JMS\Serializer\Naming\CamelCaseNamingStrategy;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use JMS\Serializer\XmlDeserializationVisitor;
use JMS\Serializer\XmlSerializationVisitor;
use JMS\Serializer\YamlSerializationVisitor;
use JMSSerializerModule\Metadata\Driver\LazyLoadingDriver;
use JMSSerializerModule\Options\Handlers;
use JMSSerializerModule\Options\Metadata;
use JMSSerializerModule\Options\PropertyNaming;
use JMSSerializerModule\Options\Visitors;
use JMSSerializerModule\Service\CamelCaseNamingStrategyFactory;
use JMSSerializerModule\Service\DateTimeHandlerFactory;
use JMSSerializerModule\Service\EventDispatcherFactory;
use JMSSerializerModule\Service\FileLocatorFactory;
use JMSSerializerModule\Service\HandlerRegistryFactory;
use JMSSerializerModule\Service\MetadataCacheFactory;
use JMSSerializerModule\Service\MetadataDriverFactory;
use JMSSerializerModule\View\Serializer;
use Metadata\Driver\DriverChain;
use Metadata\Driver\FileLocator;
use Metadata\MetadataFactory;
use Zend\Di\ServiceLocator;
use Zend\Loader\AutoloaderFactory;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Loader\StandardAutoloader;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\ServiceManager\ServiceManager;

/**
 * Base module for JMS Serializer
 *
 * @author Martin Parsiegla <martin.parsiegla@gmail.com>
 */
class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface,
    ViewHelperProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function getAutoloaderConfig()
    {
        return array(
            AutoloaderFactory::STANDARD_AUTOLOADER => array(
                StandardAutoloader::LOAD_NS => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * {@inheritDoc}
     */
    public function getServiceConfig()
    {
        return array(
            'aliases' => array(
                'jms_serializer.metadata_driver' => 'jms_serializer.metadata.chain_driver',
                'jms_serializer.object_constructor' => 'jms_serializer.unserialize_object_constructor',
            ),
            'factories' => array(
                'jms_serializer.handler_registry' => new HandlerRegistryFactory(),
                'jms_serializer.datetime_handler' => function (ServiceManager $sm) {
                    $options = $sm->get('Configuration');
                    $options = new Handlers($options['jms_serializer']['handlers']);
                    $dateTimeOptions = $options->getDatetime();

                    return new DateHandler($dateTimeOptions['default_format'], $dateTimeOptions['default_timezone']);
                },
                'jms_serializer.event_dispatcher' => new EventDispatcherFactory(),
                'jms_serializer.metadata.cache' => new MetadataCacheFactory(),
                'jms_serializer.metadata.yaml_driver' => new MetadataDriverFactory('JMS\Serializer\Metadata\Driver\YamlDriver'),
                'jms_serializer.metadata.xml_driver' => new MetadataDriverFactory('JMS\Serializer\Metadata\Driver\XmlDriver'),
                'jms_serializer.metadata.php_driver' => new MetadataDriverFactory('JMS\Serializer\Metadata\Driver\PhpDriver'),
                'jms_serializer.metadata.file_locator' => function (ServiceManager $sm) {
                    $options = $sm->get('Configuration');
                    $options = new Metadata($options['jms_serializer']['metadata']);
                    $directories = array();

                    foreach ($options->getDirectories() as $directory) {
                        if (!isset($directory['path'], $directory['namespace_prefix'])) {
                            throw new \RuntimeException(sprintf('The directory must have the attributes "path" and "namespace_prefix, "%s" given.', implode(', ', array_keys($directory))));
                        }
                        $directories[rtrim($directory['namespace_prefix'], '\\')] = rtrim($directory['path'], '\\/');
                    }

                    return new FileLocator($directories);
                },
                'jms_serializer.metadata.annotation_driver' => function (ServiceManager $sm) {
                    $options = $sm->get('Configuration');
                    $options = new Metadata($options['jms_serializer']['metadata']);

                    $reader = new AnnotationReader();
                    $reader = new CachedReader(
                        new IndexedReader($reader),
                        $sm->get($options->getAnnotationCache())
                    );

                    return new AnnotationDriver($reader);
                },
                'jms_serializer.metadata.chain_driver' => function (ServiceManager $sm) {
                    $annotationDriver = $sm->get('jms_serializer.metadata.annotation_driver');
                    $phpDriver = $sm->get('jms_serializer.metadata.php_driver');
                    $xmlDriver = $sm->get('jms_serializer.metadata.xml_driver');
                    $yamlDriver = $sm->get('jms_serializer.metadata.yaml_driver');

                    return new DriverChain(array($yamlDriver, $xmlDriver, $phpDriver, $annotationDriver));
                },
                'jms_serializer.metadata.lazy_loading_driver' => function(ServiceManager $sm) {
                    return new LazyLoadingDriver($sm, 'jms_serializer.metadata_driver');
                },
                'jms_serializer.metadata_factory' => function (ServiceManager $sm) {
                    $options = $sm->get('Configuration');
                    $options = new Metadata($options['jms_serializer']['metadata']);
                    $lazyLoadingDriver = $sm->get('jms_serializer.metadata.lazy_loading_driver');

                    return new MetadataFactory($lazyLoadingDriver, 'Metadata\ClassHierarchyMetadata', $options->getDebug());
                },
                'jms_serializer.camel_case_naming_strategy' => function (ServiceManager $sm) {
                    $options = $sm->get('Configuration');
                    $options = new PropertyNaming($options['jms_serializer']['property_naming']);

                    return new CamelCaseNamingStrategy($options->getSeparator(), $options->getLowercase());
                },
                'jms_serializer.identical_naming_strategy' => function (ServiceManager $sm) {
                    return new IdenticalPropertyNamingStrategy();
                },
                'jms_serializer.serialized_name_annotation_strategy' => function (ServiceManager $sm) {
                    
                    $options = $sm->get('Configuration');
                    
                    if (isset($options['jms_serializer']['naming_strategy'])) {
                        
                        if ($options['jms_serializer']['naming_strategy'] == 'identical') {
                            return new SerializedNameAnnotationStrategy($sm->get('jms_serializer.identical_naming_strategy'));
                        }
                    }
                    
                    return new SerializedNameAnnotationStrategy($sm->get('jms_serializer.camel_case_naming_strategy'));
                },
                'jms_serializer.naming_strategy' => 'JMSSerializerModule\Service\NamingStrategyFactory',
                'jms_serializer.json_serialization_visitor' => function(ServiceManager $sm) {
                    $options = $sm->get('Configuration');
                    $options = new Visitors($options['jms_serializer']['visitors']);

                    $jsonOptions = $options->getJson();
                    $vistor = new JsonSerializationVisitor($sm->get('jms_serializer.naming_strategy'));
                    $vistor->setOptions($jsonOptions['options']);

                    return $vistor;
                },
                'jms_serializer.json_deserialization_visitor' => function (ServiceManager $sm) {
                    return new JsonDeserializationVisitor($sm->get('jms_serializer.naming_strategy'), $sm->get('jms_serializer.object_constructor'));
                },
                'jms_serializer.xml_serialization_visitor' => function(ServiceManager $sm) {
                    return new XmlSerializationVisitor($sm->get('jms_serializer.naming_strategy'));
                },
                'jms_serializer.xml_deserialization_visitor' => function(ServiceManager $sm) {
                    $options = $sm->get('Configuration');
                    $options = new Visitors($options['jms_serializer']['visitors']);

                    $xmlOptions = $options->getXml();
                    $visitor = new XmlDeserializationVisitor($sm->get('jms_serializer.naming_strategy'), $sm->get('jms_serializer.object_constructor'));
                    $visitor->setDoctypeWhitelist($xmlOptions['doctype_whitelist']);

                    return $visitor;
                },
                'jms_serializer.yaml_serialization_visitor' => function(ServiceManager $sm) {
                    return new YamlSerializationVisitor($sm->get('jms_serializer.naming_strategy'));
                },
                'jms_serializer.serializer' => 'JMSSerializerModule\Service\SerializerFactory',
            ),
            'invokables' => array(
                'jms_serializer.unserialize_object_constructor' => 'JMS\Serializer\Construction\UnserializeObjectConstructor',
                'jms_serializer.array_collection_handler' => 'JMS\Serializer\Handler\ArrayCollectionHandler',
                'jms_serializer.doctrine_proxy_subscriber' => 'JMS\Serializer\EventDispatcher\Subscriber\DoctrineProxySubscriber',
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'jmsSerializer' => function ($helpers) {
                    $sm = $helpers->getServiceLocator();
                    $viewHelper = new Serializer($sm->get('jms_serializer.serializer'));

                    return $viewHelper;
                },
            ),
        );
    }
}
