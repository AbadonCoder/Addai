<?php

class Database {
    private $dbname = 'playhard';
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $connection;

    public function connect() {
        $connectionStr = "mysql:host=" . $this -> host . ";dbname=" . $this -> dbname . ";charset=utf8";

        try {
            $this -> connection = new PDO($connectionStr, $this -> user, $this -> password);
            return $this -> connection;
        } catch (PDOException $e) {
            $this -> connection = "Connection error";
            echo 'ERROR: ' . $e -> getMessage();
        }
    }
}