<?php

test('Resolves data for existing key', function () {
    $expecation = new \ostark\TestKit\ExpectationResolver('Entry');
    $expecation->addKey('one()');

    $result = $expecation->resolve();

    expect($result)->toBeInstanceOf(\ostark\TestKit\Fakes\Entry::class);
});

test('Throws MissingExpectationData if file does not exist', function () {
    $expecation = new \ostark\TestKit\ExpectationResolver('does-not-exist');
    $expecation->addKey('all()');
    $expecation->resolve();
})->throws(\ostark\TestKit\Exceptions\MissingExpectationData::class);





