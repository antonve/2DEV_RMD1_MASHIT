<?php

// Services.php - Represents a service
// By Anton Van Eechaute

namespace Devine\Framework;

class Service
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
        $this->init();
    }

    public function init()
    {
        // override this method if needed
    }
}
