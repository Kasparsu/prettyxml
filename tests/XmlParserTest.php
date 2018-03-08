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
     * @dataProvider XmlFirstElementProvider
     */
    public function testIfConstructorInputIsReturnedInGetter($xml) {
        $xmlParser = new XmlParser($xml);
        $this->assertEquals($xml, $xmlParser->getXml());
    }

    /**
     * @dataProvider XmlFirstElementProvider
     */
    public function testIfSetterInputIsReturnedInGetter($xml) {
        $this->xmlParser->setXml($xml);
        $this->assertEquals($xml, $this->xmlParser->getXml());
    }

    /**
     * @dataProvider XmlFirstElementProvider
     */
    public function testIfFirstElementObjectIsCorrect($xml, $rootElementTag) {
       $this->xmlParser->setXml($xml)->parse();
       $this->assertEquals($this->xmlParser->getRootElement()->getTag(), $rootElementTag);

    }
    /**
     * @dataProvider WhitespaceProvider
     */
    public function testIfLineBrakesAreRemoved($xml, $expected){
        $this->xmlParser->setXml($xml)->parse();
        $this->assertEquals($expected, $this->xmlParser->getXml());

    }
    /**
     * @dataProvider XmlFirstElementChildrenProvider
     */
    public function testIfFirstElmentChildrenTagsAreCorrect($xml, $expectedChildrenTags){
        $this->xmlParser->setXml($xml)->parse();
        $actualChildrenTags = [];
        foreach($this->xmlParser->getRootElement()->getChildren() as $child){
            $actualChildrenTags[] = $child->getTag();
        }
        $this->assertEquals($expectedChildrenTags, $actualChildrenTags);
    }

    /**
     * @dataProvider XmlAttributeProvider
     */
    public function testIfAttributesAreCorrect($xml, $expectedAttributes){
        $this->xmlParser->setXml($xml)->parse();
        $actualAttributes = $this->xmlParser->getRootElement()->getChildren()[0]->getAttributes();

        $this->assertEquals($expectedAttributes, $actualAttributes);
    }
    public function XmlFirstElementProvider() {
        return [
            'one tag only' => ['<test></test>', 'test'],
            'exercise example' => ['<apply><csymbol encoding="OpenMath"><msub><mi>P</mi><mn>1</mn></msub></csymbol><ci>x</ci></apply>', 'apply'],
            ];
    }
    public function XmlFirstElementChildrenProvider() {
        return [
            'one tag only' => ['<test></test>', []],
            'exercise example' => ['<apply><csymbol encoding="OpenMath"><msub><mi>P</mi><mn>1</mn></msub></csymbol><ci>x</ci></apply>', ['csymbol', 'ci']],
            '3 tags' => ['<test><a>a</a><b>b</b><n>c</n></test>', ['a', 'b', 'n']],
        ];
    }
    public function XmlAttributeProvider() {
        return [
            'exercise example' => ['<apply><csymbol encoding="OpenMath"><msub><mi>P</mi><mn>1</mn></msub></csymbol><ci>x</ci></apply>', ['encoding' => 'OpenMath']],
            'multiple attributes' => ['<apply><csymbol encoding="OpenMath" emoticon="lol" funny="very"><msub><mi>P</mi><mn>1</mn></msub></csymbol><ci>x</ci></apply>', ['encoding' => 'OpenMath', 'emoticon' => 'lol', 'funny'=>'very']],
        ];
    }
    public function WhitespaceProvider() {
        return [
//            'whitespace' => ['<test> </test>', '<test></test>'],
//            'exercise example' => ['<apply><csymbol encoding="OpenMath"> <msub><mi>P</mi><mn>1</mn> </msub> </csymbol><ci>x</ci></apply>', '<apply><csymbol encoding="OpenMath"><msub><mi>P</mi><mn>1</mn></msub></csymbol><ci>x</ci></apply>'],
//            'multiple spaces' => ['<test>   <some>    </some>   </test>', '<test><some></some></test>'],
//            'tabs' => ["<test>\t<some>\t \t</some>\t\t</test>", '<test><some></some></test>'],
            'line brakes' => ["\n<test>\n<some>\n \n</some>\n\n</test>\n", '<test><some> </some></test>'],
        ];
    }
}
