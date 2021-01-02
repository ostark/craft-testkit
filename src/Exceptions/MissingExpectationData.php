<?php

declare(strict_types=1);

namespace ostark\CraftMockery\Exceptions;

use InvalidArgumentException;

final class MissingExpectationData extends InvalidArgumentException
{
    public static function path(string $path): self
    {
        return new static("Expectation file missing, create: {$path}");
    }

    public static function keys(array $keys, string $file = 'Entry.php'): self
    {
        $keys = array_map(fn ($key) => "'$key'", $keys);
        $keys = implode(' OR ', $keys);
        return new static("Array keys missing in {$file}, create {$keys}.");
    }
}
