<?php

namespace ErrorPrintHelper;

class ColorStringAscii implements ColorStringInterface
{
    public function addStringColorRed(string $str): string
    {
        return $this->colorizeInputStr($str, 'red');
    }

    public function addStringColorGreen(string $str): string
    {
        return $this->colorizeInputStr($str, 'green');
    }

    private function colorizeInputStr(string $text, string $color): string
    {
        $colors = [
            'red' => "\033[31m",
            'green' => "\033[32m",
            'yellow' => "\033[33m",
            'blue' => "\033[34m",
            'magenta' => "\033[35m",
            'cyan' => "\033[36m",
            'white' => "\033[37m",
            'reset' => "\033[0m"
        ];
        $colorCode = $colors[$color] ?? $colors['reset'];
        return $colorCode . $text . $colors['reset']; }
}