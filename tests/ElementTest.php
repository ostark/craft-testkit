<?php

use craft\elements\Entry;
use ostark\CraftMockery\QueryCollector;
use ostark\CraftMockery\Element;

beforeAll(function () {
    require_once "vendor/yiisoft/yii2/Yii.php";
    require_once "vendor/craftcms/cms/src/Craft.php";
});

test('Entry::find() method is mocked', function () {
    Element::make(Entry::class);

    expect(Entry::find())->toBeInstanceOf(QueryCollector::class);
});

test('Entry::find() with section() returns some result', function () {
    Element::make(Entry::class);
    $query = Entry::find()->section('foo');
    $result = $query->all();

    expect($result)->not()->toBeNull();
});

test('Entry::find() with where() returns some result', function () {
    Element::make(Entry::class);
    $query = Entry::find()->where(['id' => [1, 2, 3], 'status' => 2]);
    $result = $query->all();

    expect($result)->not()->toBeNull();
});

test('Entry::findOne(3) returns some result', function () {
    Element::make(Entry::class);
    $result = Entry::findOne(3);
    expect($result)->not()->toBeNull();
});
