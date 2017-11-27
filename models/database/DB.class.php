<?php

class DB
{
    public $connection;

    public static function me()
    {
        return new self;
    }

    public function getConnection()
    {
        if ($this->connection) {
            return $this->connection;
        } else {
            return $this->createConnection();
        }
    }

    public function createConnection()
    {
        $dbName = "crm";
        $user = "root";
        $pass = "123";

        try {
            $this->connection = new \PDO("mysql:dbname=$dbName;host=localhost", $user, $pass);
            //$this->connection->exec('SET NAMES utf8mb4');
            return $this->connection;
        } catch (PDOException $e) {
            echo "Возникла ошибка соединения: ".$e->getMessage();
            exit;
        }
    }
}
