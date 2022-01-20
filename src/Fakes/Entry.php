<?php

declare(strict_types=1);

namespace ostark\TestKit\Fakes;

use craft\base\Element;

class Entry extends Element
{
    public $siteId = 1;

    public function behaviors()
    {
        return [];
    }
}
