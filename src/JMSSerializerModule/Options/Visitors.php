<?php

namespace JMSSerializerModule\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * HandlerRegistry options
 *
 * @author Martin Parsiegla <martin.parsiegla@gmail.com>
 */
class Visitors extends AbstractOptions
{
    /**
     * @var array
     */
    protected $serialization = array();

    /**
     * @var array
     */
    protected $deserialization = array();

    /**
     * Contains options for json visitor.
     *
     * @var array
     */
    protected $json = array();

    /**
     * Contains options for xml visitor.
     *
     * @var array
     */
    protected $xml = array();

    /**
     * @param  array $subscribers
     * @return self
     */
    public function setSerialization($subscribers)
    {
        $this->serialization = $subscribers;

        return $this;
    }

    /**
     * @return array
     */
    public function getSerialization()
    {
        return $this->serialization;
    }

    /**
     * @param array $deserialization
     */
    public function setDeserialization($deserialization)
    {
        $this->deserialization = $deserialization;
    }

    /**
     * @return array
     */
    public function getDeserialization()
    {
        return $this->deserialization;
    }

    /**
     * @param array $json
     */
    public function setJson($json)
    {
        $this->json = $json;
    }

    /**
     * @return array
     */
    public function getJson()
    {
        return $this->json;
    }

    /**
     * @param array $xml
     */
    public function setXml($xml)
    {
        $this->xml = $xml;
    }

    /**
     * @return array
     */
    public function getXml()
    {
        return $this->xml;
    }

}
