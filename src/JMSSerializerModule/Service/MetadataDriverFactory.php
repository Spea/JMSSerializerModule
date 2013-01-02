<?php

namespace JMSSerializerModule\Service;

use Application\Module;
use JMS\Serializer\Handler\DateHandler;
use Metadata\Driver\FileLocator;
use Zend\ModuleManager\ModuleManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Martin Parsiegla <martin.parsiegla@gmail.com>
 */
class MetadataDriverFactory implements FactoryInterface
{

    /**
     * @var string
     */
    protected $driver;

    /**
     * @param string $driver
     */
    public function __construct($driver)
    {
        $this->driver = $driver;
    }


    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $driver = $this->driver;
        $fileLocator = $serviceLocator->get('jms_serializer.metadata.file_locator');
        $driver = new $driver($fileLocator);

        return $driver;
    }
}
