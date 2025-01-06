<?php

use ErrorPrintHelper\TestComponent;
use ErrorPrintHelper\ConcreteDecoratorA;
use ErrorPrintHelper\ConcreteDecoratorB;

test('Decoratorパターンを重ねる', function () {
    $component = new TestComponent();
    $decorator = new ConcreteDecoratorA($component);
    $decorator = new ConcreteDecoratorB($decorator);
    $throwable = null;

    expect($decorator->operation($throwable))->toBe('ConcreteDecoratorB(ConcreteDecoratorA(TestComponent))');
});
