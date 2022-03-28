<?php

namespace Core;

use Database\PdoConnection;
use PDO;

class Repository
{
    protected PDO $connection;

    public function __construct()
    {
        $this->connection = ServiceManager::getInstance(
            PdoConnection::class,
            App::getConfig('database')
        )->connect();
    }
}
