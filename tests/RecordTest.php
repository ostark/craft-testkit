<?php

use craft\records\Category;
use ostark\CraftMockery\Record;

beforeAll(function () {
    require_once "vendor/yiisoft/yii2/Yii.php";
});

test('Record::find() returns some result', function () {
    Record::make(Category::class);
    $result = Category::find()->where(['someField' => 'Some Value'])->one();
    expect($result)->not()->toBeNull();
});
