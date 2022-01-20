<?php

declare(strict_types=1);

namespace ostark\TestKit;

use craft\db\Query as BaseQuery;
use Mockery;
use Mockery\MockInterface;

class Query
{
    private MockInterface $mock;

    public function __construct(string $class, QueryCollector $collector)
    {
        $this->mock = Mockery::mock(
            'overload:' . BaseQuery::class
        )->makePartial()->shouldIgnoreMissing(
            $collector
        );
    }

    public static function make(?string $class = null, ?string $expectationFile = null): self
    {
        if ($class === null) {
            $class = BaseQuery::class;
        }

        if ($expectationFile === null) {
            $parts = explode('\\', $class);
            $expectationFile = $parts[array_key_last($parts)];
        }

        $collector = new QueryCollector(new ExpectationResolver($expectationFile));
        $collector->calls['select'] = '';

        return new static($class, $collector);
    }

    public function getMock(): MockInterface
    {
        return $this->mock;
    }
}
