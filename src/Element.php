<?php

declare(strict_types=1);

namespace fortrabbit\TestKit;

class Element extends AbstractModel
{
    public static function make(string $class, ?string $expectationFile = null): self
    {
        $element = new self($class, $expectationFile);
        $element->defineFind();
        $element->defineFindAll();
        $element->defineFindOne();

        return $element;
    }
}
