<?php

class Database
{

    /**
     * @var mysqli
     */
    protected $connection;

    public function __construct()
    {
        require_once 'settings.php';
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
        /** @var mysqli_stmt $statement */
        $statement = $this->connection->prepare(
            "SELECT COUNT(*)
            FROM user
            WHERE username = ? AND password = ?"
        );
        $statement->bind_param('ss', $username, $password);
        $result = $statement->execute();

        if($result){
            return $statement->get_result()->fetch_row()[0];
        }

        return false;
    }

    /**
     * @param $title
     * @param $feedback
     * @return bool
     */
    public function createFeedback($title, $feedback){
        /** @var mysqli_stmt $statement */
        $statement = $this->connection->prepare(
            "INSERT INTO feedback (title, feedback)
            VALUES (?, ?)"
        );
        $statement->bind_param('ss', $title, $feedback);
        $result = $statement->execute();

        if($result){
            return !$statement->get_result();
        }

        return false;
    }

    /**
     * @return array
     */
    public function getAllFeedback(){
        /** @var mysqli_stmt $statement */
        $statement = $this->connection->prepare(
            "SELECT title, feedback
            FROM feedback"
        );
        $result = $statement->execute();

        $feedback = [];
        if($result){
            $mysql_result = $statement->get_result();
            for ($i = $mysql_result->num_rows; $i > 0; $i--){
                $feedback[] = $mysql_result->fetch_assoc();
            }
        }

        return $feedback;
    }
}