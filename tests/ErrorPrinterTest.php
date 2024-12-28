<?php

require_once "src\ErrorPrinter.php";

test('文字列が返る(フォントを変える, 数値比較1)', function () {
    $sut = new ErrorPrinter();

    $result = $sut->printError('Failed asserting that 4 is identical to 3.');

    expect($result)->toBe('Failed asserting that <fg=red;options=bold>4</> is identical to <fg=red;options=bold>3</>.');
});

test('文字列が返る(フォントを変える, 数値比較2)', function () {
    $sut = new ErrorPrinter();

    $result = $sut->printError('Failed asserting that 1 is identical to 10.');

    expect($result)->toBe('Failed asserting that <fg=red;options=bold>1</> is identical to <fg=red;options=bold>10</>.');
});

test('文字列が返る(そのまま, foo)', function () {
    $sut = new ErrorPrinter();

    $result = $sut->printError('foo');

    expect($result)->toBe('foo');
});

test('文字列が返る(そのまま, bar)', function () {
    $sut = new ErrorPrinter();

    $result = $sut->printError('bar');

    expect($result)->toBe('bar');
});

test('文字列が返る(フォントを変える, 文字列比較)', function () {
    $sut = new ErrorPrinter();

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
-'<fg=red;options=bold>baz</>'
+'<fg=red;options=bold>test</>'");

    echo "result:" . $result;
});

// test('文字列比較テスト用', function () {
//     $sut = new ErrorPrinter();

//     $result = "test";

//     expect($result)->toBe('baz');
// });
