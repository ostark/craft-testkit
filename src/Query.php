<?php

declare(strict_types=1);

namespace ostark\TestKit;

use Mockery\MockInterface;

class Query
{
    private MockInterface $mock;

    public function __construct(QueryCollector $collector)
    {
        $this->mock = overload(
            'craft\db\Query'
        )->makePartial()->shouldIgnoreMissing(
            $collector
        );
    }

    public static function make(?string $class = null, ?string $expectationFile = null): self
    {
        if ($class === null) {
            $class = 'craft\db\Query';
        }

        if ($expectationFile === null) {
            $parts = explode('\\', $class);
            $expectationFile = $parts[array_key_last($parts)];
        }

        $collector = new QueryCollector(new ExpectationResolver($expectationFile));
        $collector->calls['select'] = '';

        return new self($collector);
    }

    public function getMock(): MockInterface
    {
        return $this->mock;
    }
}
