<?php

namespace Tests;

use Kasparsu\PrettyXml\Prettyfier;
use PHPUnit\Framework\TestCase;

class PrettyfierTest extends TestCase
{

    /**
     * @dataProvider PrettyfierProvider
     */
    public function testIfPrettifierWorksCorrectly($xml, $indentation, $expectedOutput){
        $prettyfier = new Prettyfier($xml, $indentation);
        $this->assertEquals($expectedOutput, $prettyfier->prettify());
    }

    public function PrettyfierProvider() {
        return [
            'one tag only' => ['<test></test>', "\t", "<test>\n</test>"],
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
        ];
    }
}
