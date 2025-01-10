<?php

namespace ErrorPrintHelper;

class ErrorPrintDecorator extends Decorator
{
    private $colorManager;

    public function __construct(
        Component $component,
        ColorStringInterface $colorManager
    ) {
        parent::__construct($component);
        if ($colorManager === null) {
            throw new \InvalidArgumentException('ColorManager is null');
        }
        $this->colorManager = $colorManager;
    }

    /**
     * @param PHPUnit\Event\Code\Throwable $throwable
     * @return string
     */
    public function operation($throwable)
    {
        $errorPrinter = new ErrorPrinter($this->colorManager);
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
