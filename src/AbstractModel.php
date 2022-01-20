<?php

declare(strict_types=1);

namespace ostark\TestKit;

use Mockery;
use ostark\TestKit\Concerns\DisablesYiiBehavior;
use ostark\TestKit\Concerns\MocksFindMethods;
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
     * @var \ostark\TestKit\ExpectationResolver
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
