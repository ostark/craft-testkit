<?php

if (!function_exists('entry')) {
    /**
     * Create a fake Entry
     *
     * @param array $value
     *
     * @return \ostark\CraftMockery\Fakes\Entry
     */
    function entry(array $fields = [])
    {
        return new \ostark\CraftMockery\Fakes\Entry($fields);
    }
}

if (!function_exists('record')) {
    /**
     * Create a fake Entry
     *
     * @param array $value
     *
     * @return \ostark\CraftMockery\Fakes\Record
     */
    function record(array $fields = [])
    {
        return new \ostark\CraftMockery\Fakes\Record($fields);
    }
}
