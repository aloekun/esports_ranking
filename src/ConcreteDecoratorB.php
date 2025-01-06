<?php

namespace ErrorPrintHelper;

class ConcreteDecoratorB extends Decorator
{
    public function operation($throwable)
    {
        return 'ConcreteDecoratorB(' . parent::operation($throwable) . ')';
    }
}
