<?php

namespace ErrorPrintHelper;

use NunoMaduro\Collision\Adapters\Phpunit\Style;
use Symfony\Component\Console\Output\ConsoleOutput;

class BaseErrorPrintComponent implements Component
{
    /**
     * @param \PHPUnit\Event\Code\Throwable $throwable
     * @return mixed
     */
    public function operation($throwable)
    {
        $consoleOutput = new ConsoleOutput();
        $style = new Style($consoleOutput);
        $style->writeError($throwable);
    }
}
