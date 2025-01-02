<?php

require_once "Component.php";

class TestComponent implements Component
{
    public function operation()
    {
        return 'TestComponent';
    }
}
