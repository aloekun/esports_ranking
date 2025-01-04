<?php

use PHPUnit\Event\Code\Throwable;

require_once "src/TestComponent.php";
require_once "src/ErrorPrintDecorator.php";

test("変更対象外の出力", function () {
    $testComponent = new TestComponent();
    $errorPrintDecorator = new ErrorPrintDecorator($testComponent);
    $throwable = new Throwable("test", "message", "description", "stackTrace", null);

    $result = $errorPrintDecorator->operation($throwable);

    expect($result)->toBe("TestComponent");
});

test("messageの出力", function () {
    $testComponent = new TestComponent();
    $errorPrintDecorator = new ErrorPrintDecorator($testComponent);
    $throwable = new Throwable("test", "Failed asserting that 4 is identical to 3.", "description", "stackTrace", null);

    $result = $errorPrintDecorator->operation($throwable);

    expect($result)->toBe('Failed asserting that <fg=red;options=bold>4</> is identical to <fg=red;options=bold>3</>.');
});

test("descriptionの出力", function () {
    $testComponent = new TestComponent();
    $errorPrintDecorator = new ErrorPrintDecorator($testComponent);
    $throwable = new Throwable("test", "message", "Failed asserting that two strings are identical.
--- Expected
+++ Actual
@@ @@
-'baz'
+'test'", "stackTrace", null);

    $result = $errorPrintDecorator->operation($throwable);

    expect($result)->toBe("Failed asserting that two strings are identical.
--- Expected
+++ Actual
@@ @@
-'<fg=red;options=bold>baz</>'
+'<fg=red;options=bold>test</>'");
});