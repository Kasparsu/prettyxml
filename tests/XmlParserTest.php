<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Kasparsu\PrettyXml\XmlParser;

final class XmlParserTest extends TestCase
{
    /**
     * @var XmlParser
     */
    private $xmlParser;

    public function setUp()
    {
        $this->xmlParser = new XmlParser();
    }

    /**
     * @dataProvider XmlProvider
     */
    public function testIfConstructorInputIsReturnedInGetter($xml) {
        $xmlParser = new XmlParser($xml);
        $this->assertEquals($xml, $xmlParser->getXml());
    }

    /**
     * @dataProvider XmlProvider
     */
    public function testIfSetterInputIsReturnedInGetter($xml) {
        $this->xmlParser->setXml($xml);
        $this->assertEquals($xml, $this->xmlParser->getXml());
    }

    /**
     * @dataProvider XmlProvider
     */
    public function testIfFirstElementObjectIsCorrect($xml) {
       $this->xmlParser->setXml = $xml;
    }

    public function XmlProvider() {
        return [
            'one tag only' => ['<test></test>'],
            ];
    }
}
