<?php

class ErrorPrinter
{
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
        return preg_match('/Failed asserting that two strings are identical.\n--- Expected\n\+\+\+ Actual\n@@ @@\n-\'(.*)\'\n\+\'(.*)\'/', $strInput, $matches);
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
     * 文字列に色をつける
     * @param string $strInput
     * @return string
     */
    private function addStringColorRed($strInput)
    {
        return '<fg=red;options=bold>' . $strInput . '</>';
    }


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
            return 'Failed asserting that ' . $this->addStringColorRed($matches[1]) . ' is identical to ' . $this->addStringColorRed($matches[2]) . '.';
        } elseif ($this->isDifferentString($strInput)) {
            // フォントを変える文字列を取得
            $matches = $this->getDifferentString($strInput);
            return "Failed asserting that two strings are identical.\n--- Expected\n+++ Actual\n@@ @@\n-'" . $this->addStringColorRed($matches[1]) . "'\n+'" . $this->addStringColorRed($matches[2]) . "'";
        }
        // そのまま返す
        return $strInput;
    }
}
