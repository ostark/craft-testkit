<?php

declare(strict_types=1);

namespace ostark\TestKit\Fakes;

use ostark\TestKit\Exceptions\DoNotCallMethod;
use yii\db\BaseActiveRecord;

class Record extends BaseActiveRecord
{
    public $id = 1;

    public function __set($name, $value): void
    {
        parent::setAttribute($name, $value);
    }

    public function hasAttribute($name)
    {
        return true;
    }

    public static function primaryKey(): void
    {
        throw new DoNotCallMethod();
    }

    public static function find(): void
    {
        throw new DoNotCallMethod();
    }

    public function insert($runValidation = true, $attributes = null): void
    {
        throw new DoNotCallMethod();
    }

    public static function getDb(): void
    {
        throw new DoNotCallMethod();
    }
}
