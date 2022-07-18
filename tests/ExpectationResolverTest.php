<?php

test('Resolves data for existing key', function () {
    $expecation = new \fortrabbit\TestKit\ExpectationResolver('Entry');
    $expecation->addKey('one()');

    $result = $expecation->resolve();

    expect($result)->toBeInstanceOf(\fortrabbit\TestKit\Fakes\Entry::class);
});

test('Throws MissingExpectationData if file does not exist', function () {
    $expecation = new \fortrabbit\TestKit\ExpectationResolver('does-not-exist');
    $expecation->addKey('all()');
    $expecation->resolve();
})->throws(\fortrabbit\TestKit\Exceptions\MissingExpectationData::class);





