<?php

class ErrorPrintDecorator extends Decorator
{
    /**
     * @param PHPUnit\Event\Code\Throwable $throwable
     * @return string
     */
    public function operation($throwable)
    {
        $errorPrinter = new ErrorPrinter();
        // 目的のエラーメッセージを含む場合は、書き換えて出力
        $message = $throwable->message();
        // print("message: $message\n");
        if ($errorPrinter->isChangePrint($message)) {
            return $errorPrinter->printError($message);
        }

        $message = $throwable->description();
        // print("description: $message\n");
        if ($errorPrinter->isChangePrint($message)) {
            return $errorPrinter->printError($message);
        }

        // print("before parent::operation\n");
        // 親の処理をそのまま実行
        return parent::operation($throwable);
    }
}
