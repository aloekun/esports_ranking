<?php

require_once 'src/Calculator.php';

test("正数の和", function () {
    $sut = new Calculator();

    $result = $sut->add(2, 2);

    expect($result)->toBe(4);
});

test("正数と負数の和", function () {
    $sut = new Calculator();

    $result = $sut->add(1, -2);

    expect($result)->toBe(-1);
});
