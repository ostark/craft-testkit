<?php

declare(strict_types=1);

namespace ostark\CraftMockery;

use Craft;

class Record extends AbstractModel
{
    public static function make(string $class, ?string $expectationFile = null): self
    {
        Craft::$app->db->setDriverName('mysql');

        $record = new static($class, $expectationFile);
        $record->defineFind();
        $record->defineFindAll();
        $record->defineFindOne();

        return $record;
    }
}
