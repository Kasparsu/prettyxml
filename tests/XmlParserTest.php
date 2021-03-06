<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Kasparsu\PrettyXml\XmlParser;

final class XmlParserTest extends TestCase {
    /**
     * @var XmlParser
     */
    private $xmlParser;

    /**
     * PHPUnit setup method
     */
    public function setUp() {
        $this->xmlParser = new XmlParser();
    }

    /**
     * @dataProvider xmlFirstElementProvider
     */
    public function testIfConstructorInputIsReturnedInGetter($xml) {
        $xmlParser = new XmlParser($xml);
        $this->assertEquals($xml, $xmlParser->getXml());
    }

    /**
     * @dataProvider xmlFirstElementProvider
     */
    public function testIfSetterInputIsReturnedInGetter($xml) {
        $this->xmlParser->setXml($xml);
        $this->assertEquals($xml, $this->xmlParser->getXml());
    }

    /**
     * @dataProvider xmlFirstElementProvider
     */
    public function testIfFirstElementObjectIsCorrect($xml, $rootElementTag) {
        $this->xmlParser->setXml($xml)->parse();
        $this->assertEquals($this->xmlParser->getRootElement()->getTag(), $rootElementTag);

    }

    /**
     * @dataProvider lineBreakProvider
     */
    public function testIfLineBrakesAreRemoved($xml, $expected) {
        $this->xmlParser->setXml($xml)->parse();
        $this->assertEquals($expected, $this->xmlParser->getXml());

    }

    /**
     * @dataProvider xmlFirstElementChildrenProvider
     */
    public function testIfFirstElmentChildrenTagsAreCorrect($xml, $expectedChildrenTags) {
        $this->xmlParser->setXml($xml)->parse();
        $actualChildrenTags = [];
        foreach ($this->xmlParser->getRootElement()->getChildren() as $child) {
            $actualChildrenTags[] = $child->getTag();
        }
        $this->assertEquals($expectedChildrenTags, $actualChildrenTags);
    }

    /**
     * @dataProvider xmlAttributeProvider
     */
    public function testIfAttributesAreCorrect($xml, $expectedAttributes) {
        $this->xmlParser->setXml($xml)->parse();
        $actualAttributes = $this->xmlParser->getRootElement()->getChildren()[0]->getAttributes();

        $this->assertEquals($expectedAttributes, $actualAttributes);
    }

    /**
     * @dataProvider firstTagFunctionProvider
     */
    public function testFirstTagFunction($xml, $expectedTag){
       $this->assertEquals($expectedTag, $this->xmlParser->getFirstTag($xml));
    }
    /**
     * @dataProvider getFirstTagAttributesProvider
     */
    public function testGetFirstTagAttributes($xml, $expectedAttributes){
        $this->assertEquals($expectedAttributes, $this->xmlParser->getFirstTagAttributes($xml));
    }

    /**
     * @return array
     */
    public function getFirstTagAttributesProvider() {
        return [
            'one attribute' => ['<test hello="hi"></test>', ['hello' => 'hi']],
            'multiple attribute' => ['<csymbol encoding="OpenMath" hello="hi" lol="joke" omg="oh my god"></csymbol>', ['encoding' => 'OpenMath', 'hello' => 'hi', 'lol'=> 'joke', 'omg' => 'oh my god']],
            'shorthand' => ['<short encoding="OpenMath" hello="hi" />', ['encoding' => 'OpenMath', 'hello' => 'hi']],
            'will get first tag' => ['<short encoding="OpenMath"></short><short encoding="lol"></short>', ['encoding' => 'OpenMath']],
        ];
    }

    /**
     * @return array
     */
    public function firstTagFunctionProvider() {
        return [
            'one tag only' => ['<test></test>', 'test'],
            'exercise example' => ['<csymbol encoding="OpenMath"><msub><mi>P</mi><mn>1</mn></msub></csymbol><ci>x</ci>', 'csymbol'],
            'shorthand' => ['<short/>', 'short'],
            'shorthand attributes' => ['<short encoding="OpenMath"/>', 'short'],
        ];
    }

    /**
     * @return array
     */
    public function xmlFirstElementProvider() {
        return [
            'one tag only' => ['<test></test>', 'test'],
            'exercise example' => ['<apply><csymbol encoding="OpenMath"><msub><mi>P</mi><mn>1</mn></msub></csymbol><ci>x</ci></apply>', 'apply'],
        ];
    }

    /**
     * @return array
     */
    public function xmlFirstElementChildrenProvider() {
        return [
            'one tag only' => ['<test></test>', []],
            'exercise example' => ['<apply><csymbol encoding="OpenMath"><msub><mi>P</mi><mn>1</mn></msub></csymbol><ci>x</ci></apply>', ['csymbol', 'ci']],
            '3 tags' => ['<test><a>a</a><b>b</b><n>c</n></test>', ['a', 'b', 'n']],
        ];
    }

    /**
     * @return array
     */
    public function xmlAttributeProvider() {
        return [
            'exercise example' => ['<apply><csymbol encoding="OpenMath"><msub><mi>P</mi><mn>1</mn></msub></csymbol><ci>x</ci></apply>', ['encoding' => 'OpenMath']],
            'multiple attributes' => ['<apply><csymbol encoding="OpenMath" emoticon="lol" funny="very"><msub><mi>P</mi><mn>1</mn></msub></csymbol><ci>x</ci></apply>', ['encoding' => 'OpenMath', 'emoticon' => 'lol', 'funny' => 'very']],
        ];
    }

    /**
     * @return array
     */
    public function lineBreakProvider() {
        return [
            'line brakes' => ["\n<test>\n<some>\n \n</some>\n\n</test>\n", '<test><some> </some></test>'],
        ];
    }
}
