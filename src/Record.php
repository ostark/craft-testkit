<?php

namespace ostark\CraftMockery;

use ostark\CraftMockery\Concerns\DisablesYiiBehavior;
use ostark\CraftMockery\Concerns\MocksFindMethods;

class Record
{
    const TYPE = 'record';

    /**
     * @var \Mockery\Mock | mixed
     */
    protected $mock;

    protected string $className;
    protected ExpectationResolver $expectation;

    use MocksFindMethods, DisablesYiiBehavior;

    public function __construct($fqn)
    {
        $this->disableCustomFieldBehavior();

        $this->mock      = \Mockery::mock('overload:' . $fqn)->makePartial();
        $this->className = (new \ReflectionClass($fqn))->getShortName();
        $this->expectation = new ExpectationResolver(static::TYPE, $this->className);
    }

    public static function make(string $class): self
    {
        $record = new static($class);
        $record->defineFind();
        $record->defineFindAll();
        $record->defineFindOne();

        return $record;
    }

    /**
     * @return mixed|\Mockery\Mock
     */
    public function getMock()
    {
        return $this->mock;
    }

    public function getExpectation()
    {
        return $this->expectation;
    }
}
