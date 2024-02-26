<?php

/**
 * Run any of these commands to calculate route time:
 * php tools/route-time.php data1.txt A1 A2 B1 B2
 * php tools/route-time.php data1.txt CR A1 A2 B1 B2
 */

require_once __DIR__ . '/../vendor/autoload.php';

$file   = $argv[1];
$points = array_slice($argv, 2);

if (!in_array('CR', $points)) {
    array_unshift($points, 'CR');
}

$parser = new FileParser(__DIR__ . '/../data/' . $file);
$times  = $parser->getTimes();

$time = 0;
for ($i = 1; $i < count($points); $i++) {
    $prev  = $points[$i - 1];
    $point = $points[$i];
    $time += $times[$prev][$point];
}
echo $time . "\n";
