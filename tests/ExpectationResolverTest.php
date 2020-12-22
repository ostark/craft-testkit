<?php

use craft\elements\Entry;
use craft\records\Category;
use ostark\CraftMockery\Element;
use ostark\CraftMockery\Record;

test('Throws MissingExpectationData if file does not exist', function () {
    $expecation = new \ostark\CraftMockery\ExpectationResolver('does-not-exist', 'Foo');
    $expecation->addKey('all()');
    $expecation->resolve();
})->throws(\ostark\CraftMockery\Exceptions\MissingExpectationData::class);


test('Resolves data for existing key', function () {
    $expecation = new \ostark\CraftMockery\ExpectationResolver('element', 'Entry');
    $expecation->addKey('one()');

    $result = $expecation->resolve();

    expect($result)->toBe(['fallback result for: one()']);
});


