<?php

namespace ostark\CraftMockery;

use ostark\CraftMockery\Concerns\DisablesYiiBehavior;
use ostark\CraftMockery\Concerns\MocksFindMethods;

abstract class AbstractModel
{

    /**
     * @var \Mockery\Mock | mixed
     */
    protected $mock;

    /**
     * @var \ostark\CraftMockery\ExpectationResolver
     */
    protected $expectation;

    use MocksFindMethods, DisablesYiiBehavior;

    public function __construct(string $class, string $expectationFile = null)
    {
        $this->disableCustomFieldBehavior();

        $this->mock      = \Mockery::mock('overload:' . $class)->makePartial();
        $this->expectation = new ExpectationResolver($expectationFile ?: (new \ReflectionClass($class))->getShortName());
    }


    public static function setConstants(string $class, array $constantsMap): void
    {
        $map = \Mockery::getConfiguration()->getConstantsMap();
        $map[$class] = $constantsMap;

        \Mockery::getConfiguration()->setConstantsMap($map);
    }


    /**
     * @return mixed|\Mockery\Mock
     */
    public function getMock()
    {
        return $this->mock;
    }

    public function getExpectation(): ExpectationResolver
    {
        return $this->expectation;
    }
}
