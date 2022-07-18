<?php


test('Custom query returns result', function () {

    \fortrabbit\TestKit\Service::all();
    \fortrabbit\TestKit\Query::make();

    $customQueryResult = (new \craft\db\Query())
        ->select('some_field')
        ->from('foo')
        ->where(['uid' => 1])
        ->all();

    expect($customQueryResult)->toBe(['result for: select().from(foo).where({uid:1}).all()']);

});


test('DB Transaction methods return null', function () {
    \fortrabbit\TestKit\Service::all();
    $transaction = \Craft::$app->db->beginTransaction();
    expect($transaction)->toBeNull();
});

test('DB open does not try to connect to DB', function () {
    \fortrabbit\TestKit\Service::all();
    $connection = \Craft::$app->db->open();
    expect($connection)->toBeNull();
});


afterEach(function () {
    \Mockery::close();
});

