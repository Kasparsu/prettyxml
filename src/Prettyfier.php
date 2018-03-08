<?php

namespace Kasparsu\PrettyXml;

class Prettyfier
{
    /**
     * @var string
     */
    private $contents;
    /**
     * @var string
     */
    private $indentation;

    /**
     * Prettyfier constructor.
     */
    public function __construct($contents, $indentation = '    ')
    {
        $this->indentation = $indentation;
        $this->contents = $contents;
        $this->parser = new XmlParser($contents);
    }

    /**
     * @return string
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * @param string $contents
     */
    public function setContents($contents)
    {
        $this->contents = $contents;
    }

    /**
     * @return string
     */
    public function getIndentation()
    {
        return $this->indentation;
    }

    /**
     * @param string $indentation
     */
    public function setIndentation($indentation)
    {
        $this->indentation = $indentation;
    }

    public function prettify(){
        $this->parser->parse();
        return $this->createFormatedXmlFromElement($this->parser->getRootElement());
    }

    private function createFormatedXmlFromElement(XmlElement $element, $output="", $level = 0){
        if($level){
            $output .="\n" . str_repeat($this->indentation, $level);
        }
        $output .= "<{$element->getTag()}";
        foreach($element->getAttributes() as $key=>$value) {
            $output .= " " . $key . "=";
            if(gettype ($value) == "string") {
                $output .= '"' . $value . '"';
            } else {
                $output .= $value;
            }
        }
        $output .= ">";
        foreach($element->getChildren() as $child){
           $output = $this->createFormatedXmlFromElement($child, $output, $level+1);
        }
        $output .= $element->getValue();
        if($element->getValue() == "")
            $output .="\n" . str_repeat($this->indentation, $level);
        $output .= "</{$element->getTag()}>";
        return $output;
    }
}