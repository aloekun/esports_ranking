<?php

namespace ErrorPrintHelper;

class ConcreteDecoratorA extends Decorator
{
    public function operation($throwable)
    {
        return 'ConcreteDecoratorA(' . parent::operation($throwable) . ')';
    }
}
