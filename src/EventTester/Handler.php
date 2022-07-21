<?php

namespace fortrabbit\TestKit\EventTester;

use yii\base\Event;

class Handler
{
    public function __construct(public Collection $events)
    {
    }

    public function __invoke(Event $event)
    {
        $event->handled = true;
        $this->events->add($event);
    }
}
