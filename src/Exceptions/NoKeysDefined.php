<?php

namespace ostark\CraftMockery\Exceptions;

class NoKeysDefined extends \Exception
{
    public static function forClass($className)
    {
        return new static("No keys defined for: $className");
    }
}
