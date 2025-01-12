<?php

use ErrorPrintHelper\ErrorPrinter;
use ErrorPrintHelper\ColorStringAscii;
use ErrorPrintHelper\ColorStringHttp;

test('文字列が返る(HTTP色変え, pest数値比較1)', function () {
    $colorManager = new ColorStringHttp();
    $sut = new ErrorPrinter($colorManager);
    $target = 'Failed asserting that 4 is identical to 3.';

    $result = $sut->printError($target);

    $countTarget = strlen($target);
    $countResult = strlen($result);
    expect($countResult)->toBeGreaterThan($countTarget);
    expect($result)->toContain('red');
    expect($result)->toContain('green');
});

test('文字列が返る(HTTP色変え, pest数値比較2)', function () {
    $colorManager = new ColorStringHttp();
    $sut = new ErrorPrinter($colorManager);
    $target = 'Failed asserting that 1 is identical to 10.';

    $result = $sut->printError($target);

    $countTarget = strlen($target);
    $countResult = strlen($result);
    expect($countResult)->toBeGreaterThan($countTarget);
    expect($result)->toContain('red');
    expect($result)->toContain('green');
});

test('文字列が返る(HTTP色変え, クラス不明)', function () {
    $colorManager = new ColorStringHttp();
    $sut = new ErrorPrinter($colorManager);
    $target = 'Class "TestClass" not found';

    $result = $sut->printError($target);

    $countTarget = strlen($target);
    $countResult = strlen($result);
    expect($countResult)->toBeGreaterThan($countTarget);
    expect($result)->toContain('red');
});

test('文字列が返る(HTTP色変え, phpunit数値比較)', function () {
    $colorManager = new ColorStringHttp();
    $sut = new ErrorPrinter($colorManager);
    $target = 'Failed asserting that 5 matches expected 4.';

    $result = $sut->printError($target);

    $countTarget = strlen($target);
    $countResult = strlen($result);
    expect($countResult)->toBeGreaterThan($countTarget);
    expect($result)->toContain('red');
    expect($result)->toContain('green');
});

test('文字列が返る(そのまま, foo)', function () {
    $colorManager = new ColorStringHttp();
    $sut = new ErrorPrinter($colorManager);

    $result = $sut->printError('foo');

    expect($result)->toBe('foo');
});

test('文字列が返る(そのまま, bar)', function () {
    $colorManager = new ColorStringHttp();
    $sut = new ErrorPrinter($colorManager);

    $result = $sut->printError('bar');

    expect($result)->toBe('bar');
});

test('文字列が返る(HTTP色変え, 文字列比較)', function () {
    $colorManager = new ColorStringHttp();
    $sut = new ErrorPrinter($colorManager);
    $target = "Failed asserting that two strings are identical.
--- Expected
+++ Actual
@@ @@
-'baz'
+'test'";

    $result = $sut->printError($target);

    $countTarget = strlen($target);
    $countResult = strlen($result);
    expect($countResult)->toBeGreaterThan($countTarget);
    expect($result)->toContain('red');
    expect($result)->toContain('green');
});

test('文字列が返る(ASCII色変え, 数値比較)', function () {
    $colorManager = new ColorStringAscii();
    $sut = new ErrorPrinter($colorManager);
    $target = 'Failed asserting that 4 is identical to 3.';

    $result = $sut->printError($target);

    $countTarget = strlen($target);
    $countResult = strlen($result);
    expect($countResult)->toBeGreaterThan($countTarget);
    expect($result)->toContain("\033[31m");
    expect($result)->toContain("\033[32m");
});

test('文字列が返る(ASCII色変え, 文字列比較)', function () {
    $colorManager = new ColorStringAscii();
    $sut = new ErrorPrinter($colorManager);
    $target = "Failed asserting that two strings are equal.
--- Expected
+++ Actual
@@ @@
-'Hello, Dog!'
+'Hello, World!'";

    $result = $sut->printError($target);

    $countTarget = strlen($target);
    $countResult = strlen($result);
    expect($countResult)->toBeGreaterThan($countTarget);
    expect($result)->toContain("\033[31m");
    expect($result)->toContain("\033[32m");
});
