<?php

class FileParser {
    private $times = [];

    public function __construct($file) {
        $this->readFile($file);
    }

    /**
     * @noinspection PhpMissingParamTypeInspection
     * @param string $file
     * @return void
     */
    private function readFile($file) {
        if (!is_string($file)) {
            throw new InvalidArgumentException('File argument not found');
        }

        $filename = basename($file);
        $file     = __DIR__ . '/../data/' . $filename;
        if (!is_file($file)) {
            throw new InvalidArgumentException("File {$filename} parse error. File not found.");
        }

        $lines = file($file);
        if ($lines === false) {
            throw new InvalidArgumentException("File {$filename} parse error. Can't read the file.");
        }

        // Ignore blank lines
        $lines = array_values(array_filter($lines, function ($line) {
            return trim($line) !== '';
        }));

        // Read the first line in the file
        $line = array_shift($lines);
        $keys = $this->readLine($line);
        $size = count($keys);

        // Validate column keys from the first line
        $expectedCount = max(2, (int) ceil(($size - 1) / 2) * 2);
        $expectedKeys  = ['CR'];
        for ($i = 1, $letter = 'A'; $i <= $expectedCount; $i++) {
            $expectedKeys[] = $letter . (($i % 2) ? '1' : '2');
            if ($i % 2 === 0) {
                $letter++;
            }
        }

        if ($expectedKeys !== $keys) {
            throw new Exception(
                "File {$filename} parse error. Invalid first row.\n"
                . "Expected: " . implode(' ', $expectedKeys) . "\n"
                . "Actual:   " . implode(' ', $keys)
            );
        }

        if (count($lines) !== $size) {
            throw new Exception(
                "File {$filename} parse error. Invalid rows count.\n"
                . "Expected matrix size {$size}x{$size}."
            );
        }

        // Validate and parse data
        foreach ($lines as $i => $line) {
            $row    = $this->readLine($line);
            $rowKey = array_shift($row);

            if (count($row) !== $size) {
                throw new Exception(
                    "File {$filename} parse error.\n"
                    . "Expected matrix size {$size}x{$size}.\n"
                    . "Invalid row #" . ($i + 1) . " size (" . count($row) . "): $line"
                );
            }

            if ($rowKey !== $keys[$i]) {
                throw new Exception(
                    "File {$filename} parse error. Invalid row #" . ($i + 1) . " first element.\n"
                    . "Expected: " . $keys[$i] . " ...\n"
                    . "Actual:   {$line}"
                );
            }

            foreach ($keys as $colKeyIndex => $colKey) {
                $time = $row[$colKeyIndex];
                if (preg_match('/[^0-9]/', $time)) {
                    throw new Exception(
                        "File {$filename} parse error. Invalid value [{$rowKey}][$colKey]: {$time}\n"
                        . "Positive integer was expected."
                    );
                }

                $time = (int) $time;
                if ($colKey === $rowKey && $time !== 0) {
                    throw new Exception(
                        "File {$filename} parse error. Invalid value [{$rowKey}][$colKey]: {$time}\n"
                        . "Diagonal elements must be equal to zero."
                    );
                }

                $this->times[$rowKey][$colKey] = $time;
            }
        }
    }

    /**
     * @noinspection PhpMissingParamTypeInspection
     * @param string $line
     * @return string[]
     */
    private function readLine($line) {
        return preg_split('/[\s\t]+/', $line, -1, PREG_SPLIT_NO_EMPTY);
    }

    public function getTimes() {
        return $this->times;
    }
}
