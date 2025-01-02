<?php

require_once "Decorator.php";

class ConcreteDecoratorA extends Decorator
{
    public function operation()
    {
        return 'ConcreteDecoratorA(' . parent::operation() . ')';
    }
}
