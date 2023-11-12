<?php

/** @noinspection DuplicatedCode */
ini_set('error_reporting', E_ALL);
ini_set('memory_limit', '1024M');

require_once __DIR__ . '/vendor/autoload.php';

$parser = new FileParser($argv[1] ?? null);

// TODO: Solve problem 1
