<?php

require_once('database/db.php');

class User {
    private $username;
    private $password;
    private $match;

    public function __construct($username, $password, $match) {
        $this -> username = $username;
        $this -> password = $password;
        $this -> match = $match;
    }

    public function createUser() {
        $response = $this -> validateData();

        if($response['type'] !== 'success') {
            return $response;
        }
        
        $db = new Database();
        $connection = $db -> connect();
        
        $sql = "CALL playhard.CREATE_USER(:username, :password)";
        $query = $connection -> prepare($sql);
        $query -> bindParam(':username', $this -> username);
        $query -> bindParam(':password', $this -> password);

        if($query -> execute()) {
            $query = null;
            $connection = null;

            return [
                'msg' => 'Usuario creado exitosamente',
                'type' => 'success'
            ];
        } else {
            $query = null;
            $connection = null;

            return [
                'msg' => 'Ups! Algo salió mal',
                'type' => 'error'
            ];
        }
    }

    private function validateData() {
        $this -> username = trim($this -> username);
        $this -> password = trim($this -> password);
        $this -> match = trim($this -> match);

        // Check if the fields are empty or not
        if(empty($this -> username) || empty($this -> password) || empty($this -> match)) {
            return [
                'msg' => 'Todos los campos son obligatorios',
                'type' => 'error'
            ];
        }

        $this -> password = password_hash($this -> password, PASSWORD_BCRYPT);

        // Validate if the password match
        if(!password_verify($this -> match, $this -> password)) {
            return [
                'msg' => 'Las contraseñas no coinciden',
                'type' => 'error'
            ];
        }

        return [
            'type' => 'success'
        ];
    }

    public static function login($username, $password) {
        $username = trim($username);
        $password = trim($password);

        if(empty($username) || empty($password)) {
            return [
                'msg' => 'Todos los campos son obligatorios',
                'type' => 'error'
            ];
        }

        $db = new Database();
        $connection = $db -> connect();

        $sql = "CALL playhard.GET_USER(:username);";
        $query = $connection -> prepare($sql);
        $query -> bindParam(':username', $username);
        $query -> execute();
        $user = $query -> fetch(PDO::FETCH_ASSOC); 

        if($query -> rowCount() < 1) {
            $query = null;
            $connection = null;

            return [
                'msg' => 'Este usuario no existe',
                'type' => 'error'
            ];
        }

        // Validate if the password match
        if(!password_verify($password, $user['password'])) {
            return [
                'msg' => 'Las contraseñas no coinciden',
                'type' => 'error'
            ];
        }

        session_start();
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        header('Location: home.php');
    }

    public static function logout() {
        session_start();
        session_unset();
        session_destroy();
        header('Location: index.php');
    }
}