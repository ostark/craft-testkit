<?php

namespace ostark\CraftMockery;

use ostark\CraftMockery\Concerns\DisablesYiiBehavior;
use ostark\CraftMockery\Concerns\MocksFindMethods;

class Record extends AbstractModel
{

    public static function make(string $class, string $expectationFile = null): self
    {
        $record = new static($class, $expectationFile);
        $record->defineFind();
        $record->defineFindAll();
        $record->defineFindOne();

        return $record;
    }

}
