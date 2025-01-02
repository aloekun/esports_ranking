<?php

require_once "Decorator.php";

class ConcreteDecoratorB extends Decorator
{
    public function operation()
    {
        return 'ConcreteDecoratorB(' . parent::operation() . ')';
    }
}
