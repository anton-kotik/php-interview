<?php

/** @noinspection DuplicatedCode */
ini_set('error_reporting', E_ALL);
ini_set('memory_limit', '1024M');

require_once __DIR__ . '/vendor/autoload.php';

$parser = new FileParser($argv[1] ?? null);

$times  = $parser->getTimes();
$result = null;
foreach ($times['CR'] as $point => $time) {
    if (str_ends_with($point, '1') && ($result === null || $time < $times['CR'][$result])) {
        $result = $point;
    }
}

echo $result . "\n";
