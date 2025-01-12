<?php

use ErrorPrintHelper\TestComponent;
use ErrorPrintHelper\ErrorPrintDecorator;
use ErrorPrintHelper\ColorStringHttp;

use PHPUnit\Event\Code\Throwable;

test("変更対象外の出力", function () {
    $testComponent = new TestComponent();
    $colorManager = new ColorStringHttp();
    $errorPrintDecorator = new ErrorPrintDecorator($testComponent, $colorManager);
    $throwable = new Throwable("test", "message", "description", "stackTrace", null);

    $result = $errorPrintDecorator->operation($throwable);

    expect($result)->toBe("TestComponent");
});

test("messageの出力", function () {
    $testComponent = new TestComponent();
    $colorManager = new ColorStringHttp();
    $errorPrintDecorator = new ErrorPrintDecorator($testComponent, $colorManager);
    $target = "Failed asserting that 4 is identical to 3.";
    $throwable = new Throwable("test", $target, "description", "stackTrace", null);
    
    $result = $errorPrintDecorator->operation($throwable);

    $countTarget = strlen($target);
    $countResult = strlen($result);
    expect($countResult)->toBeGreaterThan($countTarget);
    expect($result)->toContain('red');
    expect($result)->toContain('green');
});

test("descriptionの出力", function () {
    $testComponent = new TestComponent();
    $colorManager = new ColorStringHttp();
    $errorPrintDecorator = new ErrorPrintDecorator($testComponent, $colorManager);
    $target = "Failed asserting that two strings are identical.
--- Expected
+++ Actual
@@ @@
-'baz'
+'test'";
    $throwable = new Throwable("test", "message", $target, "stackTrace", null);

    $result = $errorPrintDecorator->operation($throwable);

    $countTarget = strlen($target);
    $countResult = strlen($result);
    expect($countResult)->toBeGreaterThan($countTarget);
    expect($result)->toContain('red');
    expect($result)->toContain('green');
});
