<?php
require_once "config/database.php";
class User {

    private $conn;

    public function __construct($db){

        $this->conn = $db;

    }

    public function findByEmail($email){

        $sql = "SELECT * FROM users WHERE email = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([$email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

}