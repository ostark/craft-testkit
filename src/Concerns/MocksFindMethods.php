<?php

namespace ostark\CraftMockery\Concerns;

use craft\behaviors\CustomFieldBehavior;
use ostark\CraftMockery\QueryCollector;

trait MocksFindMethods
{
    protected function defineFind(): void
    {
        $this->mock->shouldReceive('find')->andReturn(
            new QueryCollector($this->expectation)
        );
    }

    protected function defineFindOne(): void
    {
        $this->mock->shouldReceive('findOne')->andReturnUsing(function ($criteria) {

            $collector = new QueryCollector($this->expectation);

            if (is_int($criteria)) {
                $collector->id($criteria);
                return $collector->one();
            }

            $collector->where($criteria);
            return $collector->one();

        });
    }

    protected function defineFindAll(): void
    {
        $this->mock->shouldReceive('findAll')->andReturnUsing(function ($criteria) {

            $collector = new QueryCollector($this->expectation);

            // Array of ids
            if (array_values($criteria) === $criteria) {
                $collector->id($criteria);
                return $collector->all();
            }

            $collector->where($criteria);
            return $collector->one();

        });
    }

}
