<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Kasparsu\PrettyXml\XmlParser;

final class XmlParserTest extends TestCase
{
    private $xmlParser;
    public function setUp()
    {
        $this->xmlParser = new XmlParser();
    }

    /**
     * @dataProvider XmlProvider
     */
    public function testIfFirstElementObjectIsCorrect($xml)
    {
       $this->xmlParser->setXml = $xml;
    }

    public function XmlProvider()
    {
        return [
            'one tag only' => ['<test></test>'],
            ];
    }
}
