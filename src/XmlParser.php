<?php

namespace Kasparsu\PrettyXml;


class XmlParser
{
    private $xmlArray = [];
    private $xml;

    /**
     * XmlParser constructor.
     * @param $xml string
     */
    public function __construct($xml = '')
    {
        $this->xml = $xml;
    }

    public function parse(){

    }

    /**
     * @return string
     */
    public function getXml()
    {
        return $this->xml;
    }

    /**
     * @param string $xml
     */
    public function setXml($xml)
    {
        $this->xml = $xml;
    }
}