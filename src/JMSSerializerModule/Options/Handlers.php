<?php

namespace JMSSerializerModule\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * HandlerRegistry options
 *
 * @author Martin Parsiegla <martin.parsiegla@gmail.com>
 */
class Handlers extends AbstractOptions
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
     * Contains option for the date handler.
     *
     * @var array
     */
    protected $datetime = array();

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

    /**
     * @param array $datetime
     *
     * @return self
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * @return array
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

}
