<?php

declare(strict_types=1);

namespace fortrabbit\TestKit\Fakes;

use craft\base\Element;

class Entry extends Element
{
    public ?int $siteId = 1;

    public function behaviors(): array
    {
        return [
            'customFields' => [
                'class' => \fortrabbit\TestKit\Fakes\CustomFieldBehavior::class,
            ],
        ];
    }
}
