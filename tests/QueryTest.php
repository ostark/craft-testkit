<?php

beforeAll(function () {
    require_once "vendor/craftcms/cms/src/Craft.php";
});

test('query', function () {

    $mock = \Mockery::mock('overload:'.\craft\db\Query::class)->makePartial();
    $mock->shouldReceive('select', 'from', 'where', 'column')->andReturnSelf();
    $mock->shouldReceive('column')->andReturn('123');

    //$transaction = \Craft::$app->getDb()
    //->beginTransaction();

    $existingRecordIds = (new \craft\db\Query())
        ->select('uid')
        ->from('foo')
        ->where(['uid' => 1])
        ->column();

});
