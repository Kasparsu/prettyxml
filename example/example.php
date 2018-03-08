<?php

require __DIR__.'/../vendor/autoload.php';

$pretty = new \Kasparsu\PrettyXml\Prettyfier('<apply><csymbol encoding="OpenMath"><msub><mi>P</mi><mn>1</mn></msub></csymbol><ci>x</ci></apply>', "\t");
print $pretty->prettify();