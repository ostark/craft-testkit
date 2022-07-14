<?php

declare(strict_types=1);

namespace ostark\TestKit\Fakes;

use craft\base\Element;
use craft\behaviors\CustomFieldBehavior;

class Entry extends Element
{
    public ?int $siteId = 1;

    public function behaviors(): array
    {
        return [
            'customFields' => [
                'class' => \ostark\TestKit\Fakes\CustomFieldBehavior::class,
            ],
        ];
    }
}
