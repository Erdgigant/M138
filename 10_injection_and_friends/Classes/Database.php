<?php

class Database
{

    /**
     * @var mysqli
     */
    protected $connection;

    public function __construct()
    {
        require_once '../settings.php';
        $settings = getSettings();
        $this->connection = new mysqli('localhost', $settings['user'], $settings['password'], $settings['db_name']);

        if ($this->connection->connect_error) {
            throw new Exception('Could not connect to database');
        }
    }

    public function __destruct()
    {
        $this->connection->close();
    }

    /**
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function checkLogin($username, $password){
        $this->connection->prepare(
            "SELECT COUNT(*)
            FROM user
            WHERE username = $username AND $password = $password"
        );

    }

}