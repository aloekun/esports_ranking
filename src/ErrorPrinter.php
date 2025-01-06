<?php

namespace ErrorPrintHelper;

class ErrorPrinter
{
    /**
     * @param string $strInput
     * @return string
     */
    public function printError($strInput)
    {
        // 数値比較の場合
        if ($this->isDifferentNumber($strInput)) {
            // フォントを変える数値を取得
            $matches = $this->getDifferentNumber($strInput);
            return 'Failed asserting that ' . $this->addStringColorRed($matches[1]) . ' is identical to ' . $this->addStringColorGreen($matches[2]) . '.';
        } elseif ($this->isDifferentString($strInput)) {
            // フォントを変える文字列を取得
            $matches = $this->getDifferentString($strInput);
            // 改行コードが違っても対応するため、改行コードを取得
            $endOfLine = $this->getEndOfLine($strInput);
            // print("endOfLine: $endOfLine\n");
            return "Failed asserting that two strings are identical.$endOfLine--- Expected$endOfLine+++ Actual$endOfLine@@ @@$endOfLine-'" . $this->addStringColorGreen($matches[1]) . "'$endOfLine+'" . $this->addStringColorRed($matches[2]) . "'";
        }
        // そのまま返す
        return $strInput;
    }

    /**
     * フォントを変えるかどうか
     * @param string $strInput
     * @return bool
     */
    public function isChangePrint($strInput)
    {
        return $this->isDifferentNumber($strInput) || $this->isDifferentString($strInput);
    }

    /**
     * 数値比較のエラーかどうか
     * @param string $strInput  入力文字列
     * @param string[] $matches マッチした文字列
     * @return bool マッチしたかどうか
     */
    private function checkDifferentNumber($strInput, &$matches = null)
    {
        return preg_match('/Failed asserting that (-?\d+) is identical to (-?\d+)./', $strInput, $matches);
    }

    /**
     * 数値比較のエラーかどうか
     * @param string $strInput
     * @return bool
     */
    private function isDifferentNumber($strInput)
    {
        return $this->checkDifferentNumber($strInput);
    }

    /**
     * フォントを変える数値を取得
     * @param string $strInput
     * @return string[]
     */
    private function getDifferentNumber($strInput)
    {
        $matches = null;
        $this->checkDifferentNumber($strInput, $matches);
        return $matches;
    }

    /**
     * 文字列比較のエラーかどうか
     * @param string $strInput  入力文字列
     * @param string[] $matches マッチした文字列
     * @return bool マッチしたかどうか
     */
    private function checkDifferentString($strInput, &$matches = null)
    {
        return preg_match('/Failed asserting that two strings are identical.\R--- Expected\R\+\+\+ Actual\R@@ @@\R-\'(.*)\'\R\+\'(.*)\'/', $strInput, $matches);
    }

    /**
     * 文字列比較のエラーかどうか
     * @param string $strInput
     * @return bool
     */
    private function isDifferentString($strInput)
    {
        return $this->checkDifferentString($strInput);
    }

    /**
     * フォントを変える文字列を取得
     * @param string $strInput
     * @return string[]
     */
    private function getDifferentString($strInput)
    {
        $matches = null;
        $this->checkDifferentString($strInput, $matches);
        return $matches;
    }

    /**
     * 文字列にエラー色をつける
     * @param string $strInput
     * @return string
     */
    private function addStringColorRed($strInput)
    {
        return $this->colorizeInputStr($strInput, 'red');
    }

    /**
     * 文字列に成功色をつける
     * @param string $strInput
     * @return string
     */
    private function addStringColorGreen($strInput)
    {
        return $this->colorizeInputStr($strInput, 'green');
    }

    private function colorizeInputStr($strInput, $color)
    {
        return "<fg=$color;options=bold>" . $strInput . '</>';
    }

    /**
     * 改行コードを抽出する
     * @param string $strInput
     * @return string[]
     */
    private function getEndOfLine($strInput)
    {
        // 改行コードを抽出する正規表現
        $pattern = '/(\R)/';
        preg_match($pattern, $strInput, $matches);
        // 複数個ヒットするかもしれないが、先頭の一つを代表にして返す
        return $matches[1];
    }
}
