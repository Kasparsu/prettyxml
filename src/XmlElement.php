<?php
/**
 * Created by PhpStorm.
 * User: kaspa
 * Date: 06/03/2018
 * Time: 00:06
 */

namespace Kasparsu\PrettyXml;


class XmlElement
{
    /**
     * @var string
     */
    private $tag;
    /**
     * @var array
     */
    private $children = [];
    /**
     * @var array
     */
    private $attributes = [];

    /**
     * @var string
     */
    private $value = "";

    /**
     * XmlElement constructor.
     * @param string $tag
     * @param array $children
     * @param array $attributes
     */
    public function __construct(string $tag, array $children = [], array $attributes = [])
    {
        $this->tag = $tag;
        $this->children = $children;
        $this->attributes = $attributes;
    }

    /**
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * @return array
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array $children
     */
    public function setChildren(array $children)
    {
        $this->children = $children;
    }

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value)
    {
        $this->value = $value;
    }


}