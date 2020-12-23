<?php

namespace ostark\CraftMockery;

use Mockery\MockInterface;

class Query
{
    private MockInterface $mock;

    public function __construct(string $class, QueryCollector $collector)
    {
        $this->mock = \Mockery::mock('overload:' . \craft\db\Query::class)->makePartial()->shouldIgnoreMissing($collector);
    }

    public static function make(string $class = null, string $expectationFile = null): self
    {
        if (is_null($class)) {
            $class = \craft\db\Query::class;
        }

        if (is_null($expectationFile)) {
            $parts = explode('\\', $class);
            $expectationFile = $parts[array_key_last($parts)];
        }

        $collector = new \ostark\CraftMockery\QueryCollector(new ExpectationResolver($expectationFile));
        $collector->calls['select'] = '';

        return new static($class, $collector);
    }

    public function getMock(): MockInterface
    {
        return $this->mock;
    }
}
