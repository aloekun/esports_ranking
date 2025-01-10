<?php

namespace ErrorPrintHelper;

class ColorStringHttp implements ColorStringInterface
{
    public function addStringColorRed(string $str): string
    {
        return $this->colorizeInputStr($str, 'red');
    }

    public function addStringColorGreen(string $str): string
    {
        return $this->colorizeInputStr($str, 'green');
    }

    private function colorizeInputStr($strInput, $color)
    {
        return "<fg=$color;options=bold>" . $strInput . '</>';
    }
}