<?php

namespace Kasparsu\PrettyXml;


class XmlParser
{
    /**
     * @var XmlElement
     */
    private $rootElement;

    /**
     * @var string
     */
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
        $this->removeWhitespaceAndLineBreaks();
        $this->findRootElement();
    }

    /**
     * @return string
     */
    public function getXml()
    {
        return $this->xml;
    }

    /**
     * @param $xml
     * @return $this
     */
    public function setXml($xml)
    {
        $this->xml = $xml;
        return $this;
    }

    /**
     * @return XmlElement
     */
    public function getRootElement(): XmlElement
    {
        return $this->rootElement;
    }

    /**
     * @param XmlElement $rootElement
     */
    public function setRootElement(XmlElement $rootElement)
    {
        $this->rootElement = $rootElement;
    }

    public function removeWhitespaceAndLineBreaks(){
        $this->xml = preg_replace("/\n/", "", $this->xml);
    }

    private function findRootElement() {
        $rootTag = $this->getFirstTag($this->xml);

        $children = $this->getChildren($this->getXmlBetweenTag($rootTag, $this->xml));
        $attributes = $this->getFirstTagAttributes($this->xml);
        $this->rootElement = new XmlElement($rootTag, $children, $attributes);
        $this->getChildrenData($this->rootElement->getChildren(), $this->getXmlBetweenTag($rootTag, $this->xml));
    }
    private function getFirstTag($xml) {
        preg_match("/<(\w[^(><.)]*) ?.*>/", $xml, $elements);
        return explode(' ', $elements[1])[0];
    }
    private function getFirstTagAttributes($xml) {
        preg_match("/<(\w[^(><.)]+) ?.*>/", $xml, $elements);
        $tagParts = explode(' ', $elements[1]);
        unset($tagParts[0]);
        $attributes = [];
        foreach($tagParts as $attribute){
            preg_match("/(\w*)=\"?(\w*)\"?/", $attribute, $attributeParts);
            $attributes[$attributeParts[1]] = $attributeParts[2];
        }
        return $attributes;
    }

    private function getXmlBetweenTag(string $tag, string $xml){
        preg_match("/<$tag.*?>(.*)<\/$tag>/", $xml,$matches);
        return $matches[1];
    }
    private function getChildren($xml){
        $childTags = [];
            while(strlen($xml)>0) {

                $tag = $this->getFirstTag($xml);
                if($tag == ""){
                    break;
                }
                $childTags[] = new XmlElement($tag);
                $xml = preg_replace("/<$tag(.*)<\/$tag>/", "", $xml);
            }
        return $childTags;
    }
    private function getChildrenData(Array $elements, $parentInnerXml) {
        foreach($elements as $element){
            $tag = $element->getTag();
            $elementXml = $this->getXmlBetweenTag($tag, $parentInnerXml);
            $children = $this->getChildren($elementXml);
            if(count($children)==0){
                $element->setValue($elementXml);
            } else {
                $attributes = $this->getFirstTagAttributes($parentInnerXml);
                $element->setChildren($children);
                $element->setAttributes($attributes);
                $this->getChildrenData($children, $elementXml);
            }
        }
    }
}