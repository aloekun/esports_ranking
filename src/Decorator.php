<?php

namespace ErrorPrintHelper;

abstract class Decorator implements Component
{
    protected $component;

    public function __construct(Component $component)
    {
        $this->component = $component;
    }

    public function operation($throwable)
    {
        return $this->component->operation($throwable);
    }
}
