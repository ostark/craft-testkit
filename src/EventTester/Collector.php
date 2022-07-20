<?php

namespace fortrabbit\TestKit\EventTester;


use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use PHPUnit\Framework\Assert as PHPUnit;
use yii\base\Event;

class Collector
{
    public static ?Collection $events = null;

    public static function enable()
    {
        static::$events = new Collection();
        Event::on('*', '*', new Handler(static::$events));
    }

    public static function disable()
    {
        static::$events = null;
        Event::off('*', '*', new Handler(static::$events));

    }



    /**
     * Assert if an event has a handler attached to it.
     *
     * @param  string $expectedEvent
     * @param  string $expectedHandler
     *
     * @return void
     */
    public function assertHandler($expectedEvent, $expectedHandler)
    {
        foreach ($this->dispatcher->getListeners($expectedEvent) as $listenerClosure) {
            $actualListener = (new ReflectionFunction($listenerClosure))
                ->getStaticVariables()['listener'];

            if (is_string($actualListener) && Str::endsWith($actualListener, '@handle')) {
                $actualListener = Str::parseCallback($actualListener)[0];
            }

            if ($actualListener === $expectedHandler ||
                ($actualListener instanceof Closure &&
                    $expectedHandler === Closure::class)) {
                PHPUnit::assertTrue(true);

                return;
            }
        }

        PHPUnit::assertTrue(
            false,
            sprintf(
                'Event [%s] does not have the [%s] listener attached to it',
                $expectedEvent,
                print_r($expectedHandler, true)
            )
        );
    }

    /**
     * Assert if an event was dispatched based on a truth-test callback.
     *
     * @param  string|\Closure  $event
     * @param  callable|int|null  $callback
     * @return void
     */
    public function assertTriggered($className, $eventName)
    {
        if ($event instanceof Closure) {
            [$event, $callback] = [$this->firstClosureParameterType($event), $event];
        }

        if (is_int($callback)) {
            return $this->assertTriggeredTimes($event, $callback);
        }

        PHPUnit::assertTrue(
            $this->dispatched($event, $callback)->count() > 0,
            "The expected [{$event}] event was not dispatched."
        );
    }

    /**
     * Assert if an event was dispatched a number of times.
     *
     * @param  string  $event
     * @param  int  $times
     * @return void
     */
    public function assertDispatchedTimes($event, $times = 1)
    {
        $count = $this->dispatched($event)->count();

        PHPUnit::assertSame(
            $times, $count,
            "The expected [{$event}] event was dispatched {$count} times instead of {$times} times."
        );
    }

    /**
     * Determine if an event was dispatched based on a truth-test callback.
     *
     * @param  string|\Closure  $event
     * @param  callable|null  $callback
     * @return void
     */
    /*public function assertNotDispatched($event, $callback = null)
    {
        if ($event instanceof Closure) {
            [$event, $callback] = [$this->firstClosureParameterType($event), $event];
        }

        PHPUnit::assertCount(
            0, $this->dispatched($event, $callback),
            "The unexpected [{$event}] event was dispatched."
        );
    }*/

    /**
     * Assert that no events were dispatched.
     *
     * @return void
     */
    /*public function assertNothingDispatched()
    {
        $count = count(Arr::flatten($this->events));

        PHPUnit::assertSame(
            0, $count,
            "{$count} unexpected events were dispatched."
        );
    }*/


    /**
     * Determine if the given event has been dispatched.
     */
    public function wasTriggered(string $className, string $eventName)
    {
        //return isset($this->events[$event]) && ! empty($this->events[$event]);
    }


    /**
     * Determine if a given event has handlers.
     */
    public function hasHandlers($className, $eventName)
    {
        //return $this->dispatcher->hasListeners($eventName);
    }






}



