<?php

beforeAll(function () {
    require_once "vendor/yiisoft/yii2/Yii.php";
    require_once "vendor/craftcms/cms/src/Craft.php";
});

test('Custom query returns result', function () {

    \ostark\TestKit\Service::all();
    \ostark\TestKit\Query::make();

    $customQueryResult = (new \craft\db\Query())
        ->select('some_field')
        ->from('foo')
        ->where(['uid' => 1])
        ->all();

    expect($customQueryResult)->toBe(['result for: select().from(foo).where({uid:1}).all()']);

});


test('DB Transaction methods return null', function () {
    \ostark\TestKit\Service::all();
    $transaction = \Craft::$app->db->beginTransaction();
    expect($transaction)->toBeNull();
});

test('DB open does not try to connect to DB', function () {
    \ostark\TestKit\Service::all();
    $connection = \Craft::$app->db->open();
    expect($connection)->toBeNull();
});
