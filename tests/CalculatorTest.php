<?php

require_once 'src/Calculator.php';

test("正数の和", function () {
    $sut = new Calculator();

    $result = $sut->add(2, 2);

    expect($result)->toBe(4);
});
