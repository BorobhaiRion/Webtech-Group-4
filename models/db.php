<?php
class db {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $dbname = "shop_db";

    public function connection() {
        $conn = new mysqli($this->host, $this->user, $this->password, $this->dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
    public function registerUser($name, $email, $phone, $password){
        $conn = $this->connection();
        $sql = "INSERT INTO users (name, email, phone, password_hash) VALUES ('$name', '$email', '$phone', '$password')";
        
        return $conn->query($sql);
    }
     public function getUserByEmail($email){
        $conn = $this->connection();
        $sql = "SELECT * FROM users WHERE email='$email'";

        return $conn->query($sql);
    }

    public function getUserById($id){
        $conn = $this->connection();
        $sql = "SELECT * FROM users WHERE id='$id'";

        return $conn->query($sql);
    }

    public function updatePassword($id, $password){
        $conn = $this->connection();

        $sql = "UPDATE users SET password_hash='$password' WHERE id='$id'";

        return $conn->query($sql);
    }





}