<?php

namespace ostark\CraftMockery\Exceptions;

class NoKeysDefined extends \Exception
{
    public static function inFile($name)
    {
        return new static("No keys defined in file: $name");
    }
}
