<?php

namespace JMSSerializerModule\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * HandlerRegistry options
 *
 * @author Martin Parsiegla <martin.parsiegla@gmail.com>
 */
class EventDispatcher extends AbstractOptions
{
    /**
     * An array of subscribers. The array can contain the FQN of the
     * class to instantiate OR a string to be located with the
     * service locator.
     *
     * @var array
     */
    protected $subscribers = array();

    /**
     * @param  array $subscribers
     * @return self
     */
    public function setSubscribers($subscribers)
    {
        $this->subscribers = $subscribers;

        return $this;
    }

    /**
     * @return array
     */
    public function getSubscribers()
    {
        return $this->subscribers;
    }

}
