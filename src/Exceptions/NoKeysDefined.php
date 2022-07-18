<?php

declare(strict_types=1);

namespace fortrabbit\TestKit\Exceptions;

use Exception;

class NoKeysDefined extends Exception
{
    public static function inFile($name)
    {
        return new self("No keys defined in file: $name");
    }
}
