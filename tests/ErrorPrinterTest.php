<?php

use ErrorPrintHelper\ErrorPrinter;
use ErrorPrintHelper\ColorStringAscii;
use ErrorPrintHelper\ColorStringHttp;

test('文字列が返る(HTTP色変え, pest数値比較1)', function () {
    $colorManager = new ColorStringHttp();
    $sut = new ErrorPrinter($colorManager);

    $result = $sut->printError('Failed asserting that 4 is identical to 3.');

    expect($result)->toBe('Failed asserting that <fg=red;options=bold>4</> is identical to <fg=green;options=bold>3</>.');
});

test('文字列が返る(HTTP色変え, pest数値比較2)', function () {
    $colorManager = new ColorStringHttp();
    $sut = new ErrorPrinter($colorManager);

    $result = $sut->printError('Failed asserting that 1 is identical to 10.');

    expect($result)->toBe('Failed asserting that <fg=red;options=bold>1</> is identical to <fg=green;options=bold>10</>.');
});

test('文字列が返る(HTTP色変え, pestクラス不明)', function () {
    $colorManager = new ColorStringHttp();
    $sut = new ErrorPrinter($colorManager);

    $result = $sut->printError('Class "TestClass" not found');

    expect($result)->toBe('Class "<fg=red;options=bold>TestClass</>" not found');
});

test('文字列が返る(HTTP色変え, phpunit数値比較)', function () {
    $colorManager = new ColorStringHttp();
    $sut = new ErrorPrinter($colorManager);

    $result = $sut->printError('Failed asserting that 5 matches expected 4.');

    expect($result)->toBe('Failed asserting that <fg=red;options=bold>5</> matches expected <fg=green;options=bold>4</>.');
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

    $result = $sut->printError("Failed asserting that two strings are identical.
--- Expected
+++ Actual
@@ @@
-'baz'
+'test'");

    expect($result)->toBe("Failed asserting that two strings are identical.
--- Expected
+++ Actual
@@ @@
-'<fg=green;options=bold>baz</>'
+'<fg=red;options=bold>test</>'");

    // echo "result:" . $result;
});

test('文字列が返る(ASCII色変え, 数値比較1)', function () {
    $colorManager = new ColorStringAscii();
    $sut = new ErrorPrinter($colorManager);

    $result = $sut->printError('Failed asserting that 4 is identical to 3.');

    expect($result)->toBe('Failed asserting that ' . "\033[31m" . 4 . "\033[0m" . ' is identical to ' . "\033[32m" . 3 . "\033[0m" . '.');
});
