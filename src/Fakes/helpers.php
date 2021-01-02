<?php

declare(strict_types=1);

use ostark\CraftMockery\Fakes\Entry;
use ostark\CraftMockery\Fakes\Record;

if (! function_exists('entry')) {
    /**
     * Create a fake Entry
     *
     * @return \ostark\CraftMockery\Fakes\Entry
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
     * @return \ostark\CraftMockery\Fakes\Record
     */
    function record(array $fields = [])
    {
        return new Record($fields);
    }
}
