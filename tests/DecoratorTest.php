<?php

require_once "src\TestComponent.php";
require_once "src\ConcreteDecoratorA.php";
require_once "src\ConcreteDecoratorB.php";

test('Decoratorパターンを重ねる', function () {
    $component = new TestComponent();
    $decorator = new ConcreteDecoratorA($component);
    $decorator = new ConcreteDecoratorB($decorator);
    $throwable = null;

    expect($decorator->operation())->toBe('ConcreteDecoratorB(ConcreteDecoratorA(TestComponent))');
});
