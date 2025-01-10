<?php

namespace ErrorPrintHelper;

interface ColorStringInterface
{
    public function addStringColorRed(string $str): string;
    public function addStringColorGreen(string $str): string;
}
