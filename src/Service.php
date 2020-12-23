<?php

namespace ostark\CraftMockery;

use craft\db\Command;
use craft\db\Connection;
use craft\test\TestSetup;
use Mockery\MockInterface;

class Service
{
    private array $serviceMap;

    public function __construct()
    {
        if (!(\Craft::$app instanceof MockInterface)) {
            \Craft::$app = $this->applicationMock();
            \Yii::$app   = \Craft::$app;
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
            $mockedService = \Mockery::mock($class)->makePartial();
            \Craft::$app->shouldReceive($getter['method'])->andReturn($mockedService);
            \Craft::$app->set($getter['property'], $mockedService);
        }
    }

    public function mockDb(): void
    {
        $command = \Mockery::mock(Command::class)->makePartial();
        $command->shouldReceive('execute')->andReturn(1);
        $command
            ->shouldReceive('insert', 'update', 'upsert', 'replace', 'delete', 'softDelete')
            ->andReturnSelf();

        $connection = \Mockery::mock(Connection::class)->makePartial();
        $connection->shouldReceive('open', 'close', 'beginTransaction')->andReturnNull();
        $connection->shouldReceive('createCommand')->andReturn($command);
        $connection->shouldReceive('transaction')->andReturnUsing(function ($callback) {
            return call_user_func($callback, $this);
        });

        \Craft::$app->set('db', $connection);
        \Craft::$app->shouldReceive('getDb')->andReturn($connection);
        \Craft::$app->shouldReceive('get')->with('db')->andReturn($connection);
    }

    public function applicationMock(): \Mockery\MockInterface
    {
        $applicationClass = (TestSetup::appType() === 'web')
            ? \craft\web\Application::class
            : \craft\console\Application::class;

        return \Mockery::mock($applicationClass)->makePartial();
    }


    private function getCraftServiceMap(): array
    {
        $map = TestSetup::getCraftServiceMap();

        $classes = array_map(fn($row) => $row[0], $map);
        $getters = array_map(fn($row) => [
            'property' => $row[1][1],
            'method'   => $row[1][0]
        ], $map);

        return array_combine($classes, $getters);
    }
}
