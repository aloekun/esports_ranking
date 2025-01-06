<?php

namespace ErrorPrintHelper;

class TestComponent implements Component
{
    public function operation($throwable)
    {
        return 'TestComponent';
    }
}
