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
    protected $mock = null;

    public static array $mocks = [];
    /**
     * @var \ostark\TestKit\ExpectationResolver
     */
    protected $expectation;

    public function __construct(string $class, ?string $expectationFile = null)
    {
        $this->disableCustomFieldBehavior();
        $this->mock = overload($class)->makePartial();

        $shortName = $expectationFile ?: (new ReflectionClass($class))->getShortName();
        $this->expectation = new ExpectationResolver($shortName);
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
