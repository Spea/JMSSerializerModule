<?php

namespace JMSSerializerModule\Metadata\Driver;

use Metadata\Driver\DriverInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Martin Parsiegla <martin.parsiegla@gmail.com>
 */
class LazyLoadingDriver implements DriverInterface
{
    private $serviceLocator;
    private $realDriverId;

    public function __construct(ServiceLocatorInterface $container, $realDriverId)
    {
        $this->serviceLocator = $container;
        $this->realDriverId = $realDriverId;
    }


    /**
     * {@ineheritdoc}
     */
    public function loadMetadataForClass(\ReflectionClass $class)
    {
        return $this->serviceLocator->get($this->realDriverId)->loadMetadataForClass($class);
    }
}
