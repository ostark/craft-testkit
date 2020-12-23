<?php

beforeAll(function () {
    require_once "vendor/yiisoft/yii2/Yii.php";
    require_once "vendor/craftcms/cms/src/Craft.php";
});

test('App service', function (){
   \ostark\CraftMockery\Service::all();
});
