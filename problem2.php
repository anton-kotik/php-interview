<?php

/** @noinspection DuplicatedCode */
ini_set('error_reporting', E_ALL);
ini_set('memory_limit', '1024M');

require_once __DIR__ . '/vendor/autoload.php';

$parser = new FileParser($argv[1] ?? null);

class Solver {
    private array $closestPoints = [];
    public array  $resultRoute   = [];
    public int    $resultTime    = PHP_INT_MAX;

    public function __construct(FileParser $parser) {
        foreach ($parser->getTimes() as $point => $pointTimes) {
            $this->closestPoints[$point] = $pointTimes;
            unset($this->closestPoints[$point]['CR']);
            unset($this->closestPoints[$point][$point]);
            asort($this->closestPoints[$point]);
        }
    }

    public function solve(): void {
        $this->createRoutes('CR', 0, 0, []);

        echo implode(' ', $this->resultRoute), "\n";
        echo $this->resultTime, "\n";
    }

    private function createRoutes(string $curPoint, int $curTime, int $parcelsOnHands, array $route): void {
        if (count($route) === count($this->closestPoints['CR'])) {
            if ($this->resultTime > $curTime) {
                $this->resultTime  = $curTime;
                $this->resultRoute = $route;
            }
            return;
        }

        if ($curTime > $this->resultTime) {
            return;
        }

        foreach ($this->closestPoints[$curPoint] as $nextPoint => $timeToNextPoint) {
            if (array_key_exists($nextPoint, $route)) {
                continue;
            }

            if (str_ends_with($nextPoint, '2')) {
                $pickupPoint    = $nextPoint;
                $pickupPoint[1] = '1';

                if (!array_key_exists($pickupPoint, $route)) {
                    continue;
                }

                $newRoute = $route;

                $newRoute[$nextPoint] = $nextPoint;

                $this->createRoutes(
                    $nextPoint,
                    $curTime + $timeToNextPoint,
                    $parcelsOnHands - 1,
                    $newRoute,
                );
            } elseif ($parcelsOnHands < 2) {
                $newRoute = $route;

                $newRoute[$nextPoint] = $nextPoint;

                $this->createRoutes(
                    $nextPoint,
                    $curTime + $timeToNextPoint,
                    $parcelsOnHands + 1,
                    $newRoute,
                );
            }
        }
    }
}

$s = new Solver($parser);
$s->solve();
