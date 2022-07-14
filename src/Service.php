<?php

declare(strict_types=1);

namespace ostark\TestKit;

use Craft;
use craft\console\Application as ConsoleApplication;
use craft\db\Command;
use craft\db\Connection;
use craft\test\TestSetup;
use craft\web\Application as WebApplication;
use Mockery;
use Mockery\MockInterface;
use Yii;
use yii\web\Application;

class Service
{
    private array $serviceMap;

    public function __construct()
    {

        if (! (Craft::$app instanceof MockInterface)) {
            $mockedApp  = $this->applicationMock();
            Craft::$app = $mockedApp;
            Yii::$app = $mockedApp;
        }


        $this->serviceMap = $this->getCraftServiceMap();
    }

    public static function all(): void
    {
        $instance = new self();
        $instance->mockServices();
        $instance->mockDb();
    }

    public function mockServices(): void
    {
        foreach ($this->serviceMap as $class => $getter) {
            $mockedService = Mockery::mock($class)->makePartial();
            Craft::$app->shouldReceive($getter['method'])->andReturn($mockedService);
            Craft::$app->set($getter['property'], $mockedService);
        }
    }

    public function mockDb(): void
    {
        $command = Mockery::mock(Command::class)->makePartial();
        $command->allows('execute')->andReturns(1);

        foreach (['insert', 'update', 'upsert', 'replace', 'delete', 'softDelete'] as $writeCms) {
            $command->allows($writeCms)->andReturnSelf();

        }

        $connection = Mockery::mock(Connection::class)->makePartial();
        $connection->allows('open')->andReturns(null);
        $connection->allows('close')->andReturns(null);
        $connection->allows('beginTransaction')->andReturns(null);
        $connection->allows('createCommand')->andReturns($command);
        $connection->allows('transaction')->andReturnUsing(function ($callback) {
            return call_user_func($callback, $this);
        });

        Craft::$app->set('db', $connection);
        Craft::$app->allows('getDb')->andReturn($connection);
        Craft::$app->allows('get')->with('db')->andReturn($connection);
    }

    public function applicationMock(): MockInterface|WebApplication|ConsoleApplication
    {
        $applicationClass = TestSetup::appType() === 'web'
            ? WebApplication::class
            : ConsoleApplication::class;

        return Mockery::mock($applicationClass)->makePartial();
    }

    private function getCraftServiceMap(): array
    {
        $map = TestSetup::getCraftServiceMap();

        $classes = array_map(fn ($row) => $row[0], $map);
        $getters = array_map(fn ($row) => [
            'property' => $row[1][1],
            'method' => $row[1][0],
        ], $map);

        return array_combine($classes, $getters);
    }
}
