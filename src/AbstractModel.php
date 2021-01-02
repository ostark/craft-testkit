<?php

declare(strict_types=1);

namespace ostark\CraftMockery;

use Mockery;
use ostark\CraftMockery\Concerns\DisablesYiiBehavior;
use ostark\CraftMockery\Concerns\MocksFindMethods;
use ReflectionClass;

abstract class AbstractModel
{
    use MocksFindMethods;
    use DisablesYiiBehavior;

    /**
     * @var \Mockery\Mock | mixed
     */
    protected $mock;

    /**
     * @var \ostark\CraftMockery\ExpectationResolver
     */
    protected $expectation;

    public function __construct(string $class, ?string $expectationFile = null)
    {
        $this->disableCustomFieldBehavior();

        $this->mock = Mockery::mock('overload:' . $class)->makePartial();
        $this->expectation = new ExpectationResolver($expectationFile ?: (new ReflectionClass(
            $class
        ))->getShortName());
    }

    public static function setConstants(string $class, array $constantsMap): void
    {
        $map = Mockery::getConfiguration()->getConstantsMap();
        $map[$class] = $constantsMap;

        Mockery::getConfiguration()->setConstantsMap($map);
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
