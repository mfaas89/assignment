<?php

namespace Core;

abstract class Service
{
    protected ServiceManager $serviceManager;

    public function __construct()
    {
        $this->serviceManager = new ServiceManager();
    }
}
