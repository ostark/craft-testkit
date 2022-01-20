<?php

declare(strict_types=1);

use ostark\TestKit\Fakes\Entry;
use ostark\TestKit\Fakes\Record;

if (! function_exists('entry')) {
    /**
     * Create a fake Entry
     *
     * @return \ostark\TestKit\Fakes\Entry
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
     * @return \ostark\TestKit\Fakes\Record
     */
    function record(array $fields = [])
    {
        return new Record($fields);
    }
}
