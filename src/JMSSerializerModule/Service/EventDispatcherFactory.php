<?php

namespace JMSSerializerModule\Service;

use InvalidArgumentException;
use JMS\Serializer\EventDispatcher\EventDispatcher;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\Handler\DateHandler;
use JMS\Serializer\Handler\HandlerRegistry;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Martin Parsiegla <martin.parsiegla@gmail.com>
 */
class EventDispatcherFactory extends AbstractFactory
{

    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var $options \JMSSerializerModule\Options\Handlers */
        $options      = $this->getOptions($serviceLocator, 'eventdispatcher');
        $handlerRegistry = new EventDispatcher();

        foreach ($options->getSubscribers() as $subscriberName) {
            $subscriber = $subscriberName;

            if (is_string($subscriber)) {
                if ($serviceLocator->has($subscriber)) {
                    $subscriber = $serviceLocator->get($subscriber);
                } elseif (class_exists($subscriber)) {
                    $subscriber = new $subscriber();
                }
            }

            if ($subscriber instanceof EventSubscriberInterface) {
                $handlerRegistry->addSubscriber($subscriber);
                continue;
            }

            throw new InvalidArgumentException(sprintf(
                'Invalid subscriber "%s" given, must be a service name, '
                    . 'class name or an instance implementing JMS\Serializer\Handler\SubscribingHandlerInterface;
',
                is_object($subscriberName)
                    ? get_class($subscriberName)
                    : (is_string($subscriberName) ? $subscriberName : gettype($subscriber))
            ));
        }

        return $handlerRegistry;
    }

    /**
     * {@inheritDoc}
     */
    public function getOptionsClass()
    {
        return 'JMSSerializerModule\Options\Handlers';
    }
}
