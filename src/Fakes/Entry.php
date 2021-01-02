<?php

declare(strict_types=1);

namespace ostark\CraftMockery\Fakes;

use craft\base\Element;

class Entry extends Element
{
    public $siteId = 1;

    public function behaviors()
    {
        return [];
    }
}
