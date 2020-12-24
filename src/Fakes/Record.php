<?php

namespace ostark\CraftMockery\Fakes;

use yii\db\BaseActiveRecord;

class Record extends BaseActiveRecord
{
    public $id = 1;

    public function __set($name, $value)
    {
        parent::setAttribute($name, $value);
    }

    public function hasAttribute($name)
    {
        return true;
    }

    public static function primaryKey()
    {
    }

    public static function find()
    {
    }

    public function insert($runValidation = true, $attributes = null)
    {
    }

    public static function getDb()
    {
    }
}
