<?php

namespace ostark\CraftMockery;

class Element extends AbstractModel
{
    public static function make(string $class, string $expectationFile = null): self
    {
        $element = new static($class, $expectationFile);
        $element->defineFind();
        $element->defineFindAll();
        $element->defineFindOne();

        return $element;
    }

}
