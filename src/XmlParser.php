<?php

namespace Kasparsu\PrettyXml;


class XmlParser {
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
    public function __construct($xml = '') {
        ini_set('pcre.backtrack_limit', '15728640');
        $this->xml = $xml;
    }

    /**
     * parses raw xml into XmlElement objects
     */
    public function parse(): void {
        $this->removeLineBreaks();
        $this->findRootElement();
    }

    /**
     * @return string
     */
    public function getXml(): string {
        return $this->xml;
    }

    /**
     * @param $xml
     * @return $this
     */
    public function setXml($xml): XmlParser {
        $this->xml = $xml;
        return $this;
    }

    /**
     * @return XmlElement
     */
    public function getRootElement(): XmlElement {
        return $this->rootElement;
    }

    /**
     * @param XmlElement $rootElement
     */
    public function setRootElement(XmlElement $rootElement): void {
        $this->rootElement = $rootElement;
    }

    /**
     *  will remove linebrakes from xml string
     */
    public function removeLineBreaks(): void {
        $this->xml = preg_replace("/\n/", "", $this->xml);
    }

    /**
     * will find root element and its data
     */
    private function findRootElement(): void {
        $rootTag = $this->getFirstTag($this->xml);

        $children = $this->getChildren($this->getXmlBetweenTag($rootTag, $this->xml));
        $attributes = $this->getFirstTagAttributes($this->xml);
        $this->rootElement = new XmlElement($rootTag, $children, $attributes);
        $this->getChildrenData($this->rootElement->getChildren(), $this->getXmlBetweenTag($rootTag, $this->xml));
    }

    /**
     * will return first xml tag in string
     * @param $xml
     * @return string
     */
    public function getFirstTag($xml): string {
        preg_match("/<(\w[^(><.\/)]*) ?.*>/", $xml, $elements);
        return explode(' ', $elements[1])[0];
    }

    /**
     * will return attributes of first xml tag in string
     * @param $xml
     * @return array
     */
    public function getFirstTagAttributes($xml): array {

        preg_match("/<(\w[^(><)]+) ?.*>/", $xml, $elements);
        $tagParts = explode(' ', $elements[1]);
        unset($tagParts[0]);
        $attributes = [];
        foreach ($tagParts as $attribute) {
                preg_match("/(.*[^=])=\"?(.*[^\"])\"?/", $attribute, $attributeParts);
                if($attributeParts != NULL || $attributeParts[2] != NULL) {
                    $attributes[$attributeParts[1]] = $attributeParts[2];
                }
        }
        return $attributes;
    }

    /**
     * will return tags innerxml as a string
     * @param string $tag
     * @param string $xml
     * @return string
     */
    public function getXmlBetweenTag(string $tag, string $xml): string {
        preg_match('/<' . $tag . '[^(><.)]+ ?\/>|<' .$tag.'.*?>(.*?)<\/'.$tag.'>/', $xml, $matches);
        return $matches[1] ??  "";
    }

    /**
     * will get first tags children XmlElements
     * @param $xml
     * @return XmlElement[]
     */
    public function getChildren($xml): array {
        $childTags = [];
        while (strlen($xml) > 0) {
            $tag = $this->getFirstTag($xml);
            if ($tag == "") {
                break;
            }
            $childTags[] = new XmlElement($tag);
            $xml = $this->removeTagFromXml($tag, $xml);
        }
        return $childTags;
    }
    public function removeTagFromXml($tag, $xml){
        preg_match('/<' . $tag . '[^(><)]+ ?\/>|<' .$tag.'.*?>(.*?)<\/'.$tag.'>/', $xml, $match);
        return str_replace($match[0], '', $xml);
    }
    /**
     * will recursively fill in children elements and their data.
     * @param array $elements
     * @param $parentInnerXml
     */
    public function getChildrenData(Array $elements, $parentInnerXml): void {
        foreach ($elements as $element) {
            $tag = $element->getTag();
            $elementXml = $this->getXmlBetweenTag($tag, $parentInnerXml);
            $children = $this->getChildren($elementXml);
            if (count($children) == 0) {
                $element->setValue($elementXml);
            } else {
                $element->setChildren($children);
                $this->getChildrenData($children, $elementXml);
            }
            $attributes = $this->getFirstTagAttributes($parentInnerXml);
            $element->setAttributes($attributes);
            $parentInnerXml = $this->removeTagFromXml($tag, $parentInnerXml);
        }
    }
}