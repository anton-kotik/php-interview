<?php

/**
 * Run this command to generate data for orders A,B,C,D,E,F and write it into the file:
 * php generate-data.php F huge3.txt
 */

$max      = $argv[1] ?? 'C';
$filename = $argv[2] ?? null;

$keys  = ['CR'];
$times = [];

for ($letter = 'A'; $letter <= $max; $letter++) {
    $keys[] = $letter . '1';
    $keys[] = $letter . '2';
}

$content = '   ' . implode(' ', $keys) . "\n";
foreach ($keys as $rowKey) {
    $content .= $rowKey;
    foreach ($keys as $colKey) {
        $rowOrder = preg_replace('/\d+/', '', $rowKey);
        $colOrder = preg_replace('/\d+/', '', $colKey);

        if ($rowKey === $colKey) {
            $time = 0;
        } elseif (isset($times[$colKey][$rowKey])) {
            $diff = (int) round($times[$colKey][$rowKey] * 0.08);
            $time = max(2, min(99, $times[$colKey][$rowKey] + random_int(-$diff, $diff)));
        } elseif ($rowOrder === $colOrder) {
            $time = random_int(30, 99);
        } else {
            $time = random_int(2, 99);
        }

        if (!isset($times[$rowKey])) {
            $times[$rowKey] = [];
        }

        $times[$rowKey][$colKey] = $time;

        $content .= (($time < 10) ? '  ' : ' ') . $time;
    }
    $content .= "\n";
}

if ($filename) {
    file_put_contents(__DIR__ . '/../data/' . $filename, $content);
}

echo $content;
