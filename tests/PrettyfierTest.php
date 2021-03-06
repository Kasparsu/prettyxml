<?php

namespace Tests;

use Kasparsu\PrettyXml\Prettyfier;
use PHPUnit\Framework\TestCase;

class PrettyfierTest extends TestCase {

    /**
     * @dataProvider prettyfierProvider
     */
    public function testIfPrettifierWorksCorrectly($xml, $indentation, $expectedOutput) {
        $prettyfier = new Prettyfier($xml, $indentation);
        $this->assertEquals($expectedOutput, $prettyfier->prettify());
    }

    /**
     * @return array
     */
    public function prettyfierProvider(): array {
        return [
            'one tag only' => ['<test></test>', "\t", "<test/>"],
            'exercise example' => [
                '<apply><csymbol encoding="OpenMath"><msub><mi>P</mi><mn>1</mn></msub></csymbol><ci>x</ci></apply>',
                "\t",
                "<apply>\n\t<csymbol encoding=\"OpenMath\">\n\t\t<msub>\n\t\t\t<mi>P</mi>\n\t\t\t<mn>1</mn>\n\t\t</msub>\n\t</csymbol>\n\t<ci>x</ci>\n</apply>"
            ],
            'different indetation' => [
                '<test><a>a</a><b>b</b><n>c</n></test>',
                '    ',
                "<test>\n    <a>a</a>\n    <b>b</b>\n    <n>c</n>\n</test>"
            ],
            'buggy' => ['<namespaces><namespace key="-2" case="first-letter">Media</namespace><namespace key="-1" case="first-letter">Special</namespace><namespace key="0" case="first-letter" /><namespace key="1" case="first-letter">Talk</namespace></namespaces>',
            "\t",
            "<namespaces>\n\t<namespace key=\"-2\" case=\"first-letter\">Media</namespace>\n\t<namespace key=\"-1\" case=\"first-letter\">Special</namespace>\n\t<namespace key=\"0\" case=\"first-letter\"/>\n\t<namespace key=\"1\" case=\"first-letter\">Talk</namespace>\n</namespaces>"]
        ];
    }
}
