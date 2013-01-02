<?php


namespace JMSSerializerModule\Service;

use RuntimeException;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Base ServiceManager factory to be extended
 *
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @author  Kyle Spraggs <theman@spiffyjr.me>
 */
abstract class AbstractFactory implements FactoryInterface
{
    /**
     * @var \Zend\Stdlib\AbstractOptions
     */
    protected $options;

    /**
     * Gets options from configuration based on name.
     *
     * @param  ServiceLocatorInterface      $sl
     * @param  string                       $key
     * @return \Zend\Stdlib\AbstractOptions
     * @throws \RuntimeException
     */
    public function getOptions(ServiceLocatorInterface $sl, $key)
    {
        $options = $sl->get('Configuration');
        $options = $options['jms_serializer'];
        $options = isset($options[$key]) ? $options[$key] : null;

        if (null === $options) {
            throw new RuntimeException(sprintf(
                'Options with name "%s" could not be found in "jms_serializer".',
                $key
            ));
        }

        $optionsClass = $this->getOptionsClass();

        return new $optionsClass($options);
    }

    /**
     * Get the class name of the options associated with this factory.
     *
     * @abstract
     * @return string
     */
    abstract public function getOptionsClass();
}
