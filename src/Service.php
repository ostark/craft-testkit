<?php

namespace ostark\CraftMockery;

use craft\test\TestSetup;

class Service
{

    public static function mockAll(): void
    {
        \Craft::$app = self::app();

        foreach (self::getCraftServiceMap() as $class => $getter) {
            $mockedService = \Mockery::mock($class)->makePartial();
            \Craft::$app->shouldReceive($getter)->andReturn($mockedService);
        }
    }


    public static function app(): \Mockery\Mock
    {
        \Craft::$app = \Mockery::mock(\craft\web\Application::class)->makePartial();
    }


    private static function getCraftServiceMap(): array
    {
        $map     = TestSetup::getCraftServiceMap();
        $classes = array_map(fn($row) => $row[0], $map);
        $methods = array_map(fn($row) => $row[1][0], $map);

        return array_combine($classes, $methods);
    }
}
