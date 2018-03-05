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
}