<?php

namespace Database;

use PDO;

class PdoConnection
{
    protected static PDO $connection;

    /**
     * @param string $host
     * @param int $port
     * @param string $username
     * @param string $password
     * @param string $database
     */
    public function __construct(
        private string $host,
        private int    $port,
        private string $username,
        private string $password,
        private string $database,
    ) {
        $this->connect();
    }

    public function connect(): PDO
    {
        if (static::$connection ?? false) {
            return static::$connection;
        }

        return static::$connection = new PDO(
            "mysql:host=$this->host;dbname=$this->database;charset=utf8mb4;port=$this->port",
            $this->username,
            $this->password,
            [
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_ERRMODE          => PDO::ERRMODE_EXCEPTION
            ]
        );
    }
}
