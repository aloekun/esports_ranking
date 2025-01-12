<?php

namespace ErrorPrintHelper;

class ErrorPrinter
{
    private $colorManager;

    public function __construct(
        ColorStringInterface $colorManager
    ) {
        if ($colorManager === null) {
            throw new \InvalidArgumentException('ColorManager is null');
        }
        $this->colorManager = $colorManager;
    }

    /**
     * エラーを表示する
     * NOTE: ここに判定を追加する場合は、isChangePrintメソッドにも追加すること
     *       さもなくば、判定をすり抜ける
     * @param string $strInput
     * @return string
     */
    public function printError($strInput)
    {
        // print("strInput: $strInput\n");

        // $null = null;
        // $null->testMethod();
        // 数値比較の場合
        if ($this->isDifferentNumber($strInput)) {
            // print("isDifferentNumber\n");
            // フォントを変える数値を取得
            $matches = $this->getDifferentNumber($strInput);
            return 'Failed asserting that ' . $this->colorManager->addStringColorRed($matches[1]) . ' is identical to ' . $this->colorManager->addStringColorGreen($matches[2]) . '.';
        } elseif ($this->isDifferentNumberPhpUnit($strInput)) {
            // print("isDifferentNumberPhpUnit\n");
            // フォントを変える数値を取得(PHPUnit)
            $matches = $this->getDifferentNumberPhpUnit($strInput);
            return 'Failed asserting that ' . $this->colorManager->addStringColorRed($matches[1]) . ' matches expected ' . $this->colorManager->addStringColorGreen($matches[2]) . '.';
        } elseif ($this->isDifferentString($strInput)) {
            // print("isDifferentString\n");
            // フォントを変える文字列を取得
            $matches = $this->getDifferentString($strInput);
            // 改行コードが違っても対応するため、改行コードを取得
            $endOfLine = $this->getEndOfLine($strInput);
            // print("endOfLine: $endOfLine\n");
            return "Failed asserting that two strings are identical.$endOfLine--- Expected$endOfLine+++ Actual$endOfLine@@ @@$endOfLine-'" . $this->colorManager->addStringColorGreen($matches[1]) . "'$endOfLine+'" . $this->colorManager->addStringColorRed($matches[2]) . "'";
        } elseif ($this->isDifferentStringPhpUnit($strInput)) {
            // print("isDifferentStringPhpUnit\n");
            // フォントを変える文字列を取得(PHPUnit)
            $matches = $this->getDifferentStringPhpUnit($strInput);
            // 改行コードが違っても対応するため、改行コードを取得
            $endOfLine = $this->getEndOfLine($strInput);
            // print("endOfLine: $endOfLine\n");
            // return "Failed asserting that two strings are identical.$endOfLine--- Expected$endOfLine+++ Actual$endOfLine@@ @@$endOfLine-'" . $this->colorManager->addStringColorGreen($matches[1]) . "'$endOfLine+'" . $this->colorManager->addStringColorRed($matches[2]) . "'";
            return "Failed asserting that two strings are equal.$endOfLine--- Expected$endOfLine+++ Actual$endOfLine@@ @@$endOfLine-'" . $this->colorManager->addStringColorGreen($matches[1]) . "'$endOfLine+'" . $this->colorManager->addStringColorRed($matches[2]) . "'";
        } elseif ($this->isMissingClass($strInput)) {
            // print("isMissingClass\n");
            $matches = $this->getMissingClass($strInput);
            return 'Class "' . $this->colorManager->addStringColorRed($matches[1]) . '" not found';
        } elseif ($this->isMissingMethod($strInput)) {
            // print("isMissingMethod\n");
            $matches = $this->getMissingMethod($strInput);
            return 'Call to undefined method ' . $this->colorManager->addStringColorRed($matches[1]);
        }
        // print("そのまま返す\n");
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
        return $this->isDifferentNumber($strInput)
            || $this->isDifferentNumberPhpUnit($strInput)
            || $this->isDifferentString($strInput)
            || $this->isMissingClass($strInput)
            || $this->isMissingMethod($strInput);
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
     * 数値比較のエラーかどうか(PHPUnit)
     * @param string $strInput  入力文字列
     * @param string[] $matches マッチした文字列
     * @return bool マッチしたかどうか
     */
    private function checkDifferentNumberPhpUnit($strInput, &$matches = null)
    {
        return preg_match('/Failed asserting that (-?\d+) matches expected (-?\d+)./', $strInput, $matches);
    }

    /**
     * 数値比較のエラーかどうか(PHPUnit)
     * @param string $strInput
     * @return bool
     */
    private function isDifferentNumberPhpUnit($strInput)
    {
        return $this->checkDifferentNumberPhpUnit($strInput);
    }

    /**
     * フォントを変える数値を取得(PHPUnit)
     * @param string $strInput
     * @return string[]
     */
    private function getDifferentNumberPhpUnit($strInput)
    {
        $matches = null;
        $this->checkDifferentNumberPhpUnit($strInput, $matches);
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

    /**
     * 文字列比較のエラーかどうか(PHPUnit)
     * @param string $strInput  入力文字列
     * @param string[] $matches マッチした文字列
     * @return bool マッチしたかどうか
     */
    private function checkDifferentStringPhpUnit($strInput, &$matches = null)
    {
        return preg_match('/Failed asserting that two strings are equal.\R--- Expected\R\+\+\+ Actual\R@@ @@\R-\'(.*)\'\R\+\'(.*)\'/', $strInput, $matches);
    }

    /**
     * 文字列比較のエラーかどうか(PHPUnit)
     * @param string $strInput
     * @return bool
     */
    private function isDifferentStringPhpUnit($strInput)
    {
        return $this->checkDifferentStringPhpUnit($strInput);
    }

    /**
     * フォントを変える文字列を取得(PHPUnit)
     * @param string $strInput
     * @return string[]
     */
    private function getDifferentStringPhpUnit($strInput)
    {
        $matches = null;
        $this->checkDifferentStringPhpUnit($strInput, $matches);
        return $matches;
    }

    /**
     * クラスが見つからないエラーかどうか
     * @param string $strInput  入力文字列
     * @return bool マッチしたかどうか
     */
    private function isMissingClass($strInput)
    {
        return $this->checkMissingClass($strInput);
    }

    /**
     * クラスが見つからないエラーのクラス名を取得
     * @param string $strInput
     * @return string[]
     */
    private function getMissingClass($strInput)
    {
        $matches = null;
        $this->checkMissingClass($strInput, $matches);
        return $matches;
    }

    /**
     * クラスが見つからないエラーかどうか
     * @param string $strInput  入力文字列
     * @param string[] $matches マッチした文字列
     * @return bool マッチしたかどうか
     */
    private function checkMissingClass($strInput, &$matches = null)
    {
        return preg_match('/Class "(.*)" not found/', $strInput, $matches);
    }

    /**
     * メソッドが見つからないエラーかどうか
     * @param string $strInput  入力文字列
     * @return bool マッチしたかどうか
     */
    private function isMissingMethod($strInput)
    {
        return $this->checkMissingMethod($strInput);
    }

    /**
     * メソッドが見つからないエラーのメソッド名を取得
     * @param string $strInput
     * @return string[]
     */
    private function getMissingMethod($strInput)
    {
        $matches = null;
        $this->checkMissingMethod($strInput, $matches);
        return $matches;
    }

    /**
     * メソッドが見つからないエラーかどうか
     * @param string $strInput  入力文字列
     * @param string[] $matches マッチした文字列
     * @return bool マッチしたかどうか
     */
    private function checkMissingMethod($strInput, &$matches = null)
    {
        return preg_match('/Call to undefined method (.*)/', $strInput, $matches);
    }
}
