<?php


namespace ostark\CraftMockery\Concerns;

use craft\behaviors\CustomFieldBehavior;

trait DisablesYiiBehavior
{
    protected function disableCustomFieldBehavior(): void
    {
        if (\Yii::$container->has(CustomFieldBehavior::class)) {
            spl_autoload_unregister([Craft::class, 'autoload']);
            \Yii::$container->set(CustomFieldBehavior::class, new \yii\base\Behavior());
        }
    }
}
