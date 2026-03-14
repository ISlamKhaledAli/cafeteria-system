<?php

require_once __DIR__."/../config/database.php";

class User {

    private $db;

    public function __construct(){

        $database = new Database();
        $this->db = $database->connect();

    }

    public function findUserByEmail($email){

        $stmt = $this->db->prepare(
        "SELECT * FROM users WHERE email = :email"
        );

        $stmt->execute([
        "email"=>$email
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($data){

        $stmt = $this->db->prepare(
        "INSERT INTO users(name,email,password,room,extension,role,image)
        VALUES(:name,:email,:password,:room,:extension,:role,:image)"
        );

        return $stmt->execute($data);
    }

    public function getUserById($id){

        $stmt = $this->db->prepare(
        "SELECT * FROM users WHERE id=:id"
        );

        $stmt->execute([
        "id"=>$id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}