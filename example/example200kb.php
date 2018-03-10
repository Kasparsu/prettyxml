<?php
require __DIR__.'/../vendor/autoload.php';

$contents = file_get_contents(__DIR__ . '/data-200kb.xml');

$pretty = new \Kasparsu\PrettyXml\Prettyfier($contents, "\t");
$output = $pretty->prettify();
file_put_contents(__DIR__ . '/data-out-200kb.xml', $output);