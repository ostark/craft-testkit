<?php

use craft\records\Category;
use ostark\TestKit\Record;

test('Record::find() returns some result', function () {
    Record::make(Category::class);
    $result = Category::find()->where(['someField' => 'Some Value'])->one();
    expect($result)->not()->toBeNull();
});

test('Record::find() returns matching result', function () {
    Record::make(Category::class);
    $result = Category::find()->where(['someField' => 'Some Value'])->one();
    expect($result->title)->toBe('first category');
});

