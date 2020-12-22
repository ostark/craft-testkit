<?php

namespace ostark\CraftMockery;


use ostark\CraftMockery\Exceptions\MissingExpectationData;
use ostark\CraftMockery\Exceptions\NoKeysDefined;

class ExpectationResolver
{
    public string $type;
    private string $className;
    private array $keys = [];

    public function __construct(string $type, string $className)
    {
        $this->type      = $type;
        $this->className = $className;
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
            throw NoKeysDefined::forClass($this->className);
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

        throw MissingExpectationData::keys($this->keys, $this->className);
    }

    private function loadFromFile(): array
    {
        // TODO: change path
        $path = __DIR__ . "/../tests/expectations/{$this->type}/{$this->className}.php";

        if (!file_exists($path)) {
            throw MissingExpectationData::path($path, $this->className);
        }

        return require $path;
    }
}
