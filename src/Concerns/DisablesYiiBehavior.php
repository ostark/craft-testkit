<?php

declare(strict_types=1);

namespace ostark\TestKit\Concerns;

use Craft;
use craft\behaviors\CustomFieldBehavior;
use Yii;
use yii\base\Behavior;

trait DisablesYiiBehavior
{
    protected function disableCustomFieldBehavior(): void
    {
        if (Yii::$container->has(CustomFieldBehavior::class)) {
            spl_autoload_unregister([Craft::class, 'autoload']);
            Yii::$container->set(CustomFieldBehavior::class, new Behavior());
        }
    }
}
