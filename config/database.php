<?php

// used to get mysql database connection
class Database
{
    public $conn;

    // gets the database connection
    public function getConnection()
    {
        $configs = include 'config/databaseConfigs.php';
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $configs['host'] . ";dbname=" . $configs['db_name'], $configs['username'], $configs['password']);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
