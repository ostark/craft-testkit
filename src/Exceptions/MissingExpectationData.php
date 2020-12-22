<?php

namespace ostark\CraftMockery\Exceptions;

use InvalidArgumentException;

final class MissingExpectationData extends InvalidArgumentException
{
    public static function path(string $path, string $type = 'Entry'): self
    {
        return new static("Expectation file missing, create: {$path}");
    }


    public static function keys(array $keys, string $type = 'Entry'): self
    {
        $keys = array_map(fn($key) => "'$key'", $keys);
        $keys = implode(' OR ', $keys);
        return new static("Array keys missing in {$type}.php, create {$keys}.");
    }


    public static function example(string $type): string
    {
        return <<<PHP
        <?php
        // Example
        return [
            'section('foo').limit(2).all()' => [
                new ostark\CraftMockery\Dummy\\$type([
                    'id' => 1,
                    'title => 'Hello',
                ]),
                new ostark\CraftUnit\Dummy\\$type([
                    'id' => 2,
                    'title => 'World',
                ]),
            ],
            'count()' => 4
        ];
        PHP;
    }
}
