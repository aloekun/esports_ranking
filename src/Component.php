<?php

namespace ErrorPrintHelper;

interface Component
{
    /**
     * @param \PHPUnit\Event\Code\Throwable $throwable
     * @return mixed
     */
    public function operation($throwable);
}
