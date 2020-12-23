<?php

namespace ostark\CraftMockery;


use ostark\CraftMockery\Exceptions\MissingExpectationData;
use ostark\CraftMockery\Exceptions\NoKeysDefined;

class ExpectationResolver
{
    private string $expectationFile;
    private array $keys = [];

    public function __construct(string $expectationFile)
    {
        $this->expectationFile = stristr($expectationFile, '.php')
            ? $expectationFile
            : $expectationFile . '.php';

    }

    public function addKey(string $key): void
    {
        if (!isset($this->keys[$key])) {
            $this->keys[] = $key;
        }
    }

    public function resolve()
    {
        if (count($this->keys) === 0) {
            throw NoKeysDefined::inFile($this->expectationFile);
        }

        // Longest key first
        usort($this->keys, function ($a, $b) {
            return strlen($a) <=> strlen($a);
        });

        $expectations = $this->loadFromFile();

        foreach ($this->keys as $key) {
            if (isset($expectations[$key])) {
                return $expectations[$key];
            }
        }

        throw MissingExpectationData::keys($this->keys, $this->expectationFile);
    }

    private function loadFromFile(): array
    {
        // TODO: change path
        $path = __DIR__ . "/../tests/expectations/{$this->expectationFile}";

        if (!file_exists($path)) {
            throw MissingExpectationData::path($path);
        }

        return require $path;
    }
}
