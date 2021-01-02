<?php

declare(strict_types=1);

namespace ostark\CraftMockery\Exceptions;

use Exception;

class NoKeysDefined extends Exception
{
    public static function inFile($name)
    {
        return new static("No keys defined in file: $name");
    }
}
