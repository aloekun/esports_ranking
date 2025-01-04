<?php

require_once "Decorator.php";

class ConcreteDecoratorA extends Decorator
{
    public function operation($throwable)
    {
        return 'ConcreteDecoratorA(' . parent::operation($throwable) . ')';
    }
}
