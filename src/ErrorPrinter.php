<?php

class ErrorPrinter
{
    /**
     * 数値比較のエラーかどうか
     * @param string $strInput
     * @return bool
     */
    private function isDifferentNumber($strInput)
    {
        return preg_match('/Failed asserting that (\d+) is identical to (\d+)./', $strInput, $matches);
    }

    /**
     * フォントを変える数値を取得
     * @param string $strInput
     * @return string[]
     */
    private function getDifferentNumber($strInput)
    {
        preg_match('/Failed asserting that (\d+) is identical to (\d+)./', $strInput, $matches);
        return $matches;
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
            return 'Failed asserting that <fg=red;options=bold>' . $matches[1] . '</> is identical to <fg=red;options=bold>' . $matches[2] . '</>.';
        }
        // そのまま返す
        return $strInput;
    }
}
