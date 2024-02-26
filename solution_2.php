<?php

/** @noinspection DuplicatedCode */
ini_set('error_reporting', E_ALL);
ini_set('memory_limit', '1024M');

require_once __DIR__ . '/vendor/autoload.php';

$parser = new FileParser($argv[1] ?? null);

// Task 2
$times  = $parser->getTimes();
$result = null;

$points = array_keys($times['CR']);
array_shift($points);

$variants = [];

$minTime = PHP_INT_MAX;
$result  = [];
echo "\n";
foreach (permutations($points) as $k => $variant) {
    $time = 0;
    foreach ($variant as $i => $point) {
        $prev  = $i ? $variant[$i - 1] : 'CR';
        $time += $times[$prev][$point];
    }
    if ($time < $minTime) {
        $minTime = $time;
        $result  = $variant;
    }
}

echo implode(' ', $result) . "\n";
echo $minTime . "\n";

function permutations($arr, $count = 0) {
    if (count($arr) <= 1) {
        yield $arr;
        return;
    }

    foreach ($arr as $key => $value) {
        $rest = $arr;
        unset($rest[$key]);

        $isFirstPoint = str_ends_with($value, '1');
        if ($isFirstPoint) {
            if ($count === 2) {
                continue;
            }
        } elseif (in_array(str_replace('2', '1', $value), $rest)) {
            continue;
        }

        foreach (permutations($rest, $isFirstPoint ? ($count + 1) : ($count - 1)) as $perm) {
            yield array_merge([$value], $perm);
        }
    }
}
