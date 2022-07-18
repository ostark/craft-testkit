<?php

use fortrabbit\TestKit\Fakes\Entry;
use fortrabbit\TestKit\Fakes\Record;

class StaticStore {
    public static array $mocks = [];
}

if (!function_exists('overload')) {
    function overload(string $class): \Mockery\MockInterface {

        if (isset(StaticStore::$mocks[$class])) {
            Mockery::getContainer()->rememberMock(StaticStore::$mocks[$class]);
            return StaticStore::$mocks[$class];
        }
        StaticStore::$mocks[$class] = Mockery::mock('overload:'.$class);

        return StaticStore::$mocks[$class];
    }
}

if (!function_exists('alias')) {
    function alias(string $class): \Mockery\MockInterface {

        if (isset(StaticStore::$mocks[$class])) {
            Mockery::getContainer()->rememberMock(StaticStore::$mocks[$class]);
            return StaticStore::$mocks[$class];
        }
        StaticStore::$mocks[$class] = Mockery::mock('alias:'.$class);

        return StaticStore::$mocks[$class];
    }
}

if (! function_exists('entry')) {
    /**
     * Create a fake Entry
     *
     * @return \fortrabbit\TestKit\Fakes\Entry
     */
    function entry(array $fields = [])
    {
        return new Entry($fields);
    }
}

if (! function_exists('record')) {
    /**
     * Create a fake Entry
     *
     * @return \fortrabbit\TestKit\Fakes\Record
     */
    function record(array $fields = [])
    {
        return new Record($fields);
    }
}
