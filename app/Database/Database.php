<?php

namespace App\Database;

class Database
{
    private string $host;
    private string $username;
    private string $password;
    private string $database;
    private ?\PDO $connection;

    public function __construct()
    {
        $this->host = env('DB_HOST');
        $this->username = env('DB_USER');
        $this->password = env('DB_PASS');
        $this->database = env('DB_NAME');

        $this->connect();
    }

    /**
     * connect
     *
     * @return void
     */
    private function connect(): void
    {
        try {
            $this->connection = new \PDO(
                "mysql:host=$this->host;dbname=$this->database",
                $this->username,
                $this->password
            );
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die("Error database connection: " . $e->getMessage());
        }
    }

    /**
     * getConnection
     *
     * @return ?\PDO
     */
    public function getConnection(): ?\PDO
    {
        return $this->connection;
    }

    /**
     * closeConnection
     *
     * @return void
     */
    public function closeConnection()
    {
        $this->connection = null;
    }
}
