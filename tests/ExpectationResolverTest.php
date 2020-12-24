<?php

test('Throws MissingExpectationData if file does not exist', function () {
    $expecation = new \ostark\CraftMockery\ExpectationResolver('does-not-exist');
    $expecation->addKey('all()');
    $expecation->resolve();
})->throws(\ostark\CraftMockery\Exceptions\MissingExpectationData::class);


test('Resolves data for existing key', function () {
    $expecation = new \ostark\CraftMockery\ExpectationResolver('Entry');
    $expecation->addKey('one()');

    $result = $expecation->resolve();

    expect($result)->toBeInstanceOf(\ostark\CraftMockery\Fakes\Entry::class);
});


