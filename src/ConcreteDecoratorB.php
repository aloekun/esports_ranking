<?php

require_once "Decorator.php";

class ConcreteDecoratorB extends Decorator
{
    public function operation($throwable)
    {
        return 'ConcreteDecoratorB(' . parent::operation($throwable) . ')';
    }
}
