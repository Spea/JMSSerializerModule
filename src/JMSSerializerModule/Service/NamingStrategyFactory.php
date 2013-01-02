<?php

namespace JMSSerializerModule\Service;

use JMS\Serializer\Naming\CacheNamingStrategy;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Martin Parsiegla <martin.parsiegla@gmail.com>
 */
class NamingStrategyFactory extends AbstractFactory
{
    /**
     * {@inheritdoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var $options \JMSSerializerModule\Options\PropertyNaming */
        $options = $this->getOptions($serviceLocator, 'property_naming');
        /** @var $namingStrategy \JMS\Serializer\Naming\PropertyNamingStrategyInterface */
        $namingStrategy = $serviceLocator->get('jms_serializer.serialized_name_annotation_strategy');
        if ($options->getEnableCache()) {
            $namingStrategy = new CacheNamingStrategy($namingStrategy);
        }

        return $namingStrategy;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptionsClass()
    {
        return 'JMSSerializerModule\Options\PropertyNaming';
    }
}
