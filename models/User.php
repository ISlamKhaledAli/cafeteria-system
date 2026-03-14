<?php

require_once __DIR__ . '/../config/database.php';

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
            "email" => $email
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserById($id){

        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE id = :id"
        );

        $stmt->execute([
            "id" => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($data){

        $stmt = $this->db->prepare(
            "INSERT INTO users(name,email,password,role)
             VALUES(:name,:email,:password,:role)"
        );

        return $stmt->execute($data);
    }

    public function updateUser($id,$data){

        $stmt = $this->db->prepare(
            "UPDATE users SET name=:name,email=:email
             WHERE id=:id"
        );

        $data['id'] = $id;

        return $stmt->execute($data);
    }

    public function deleteUser($id){

        $stmt = $this->db->prepare(
            "DELETE FROM users WHERE id=:id"
        );

        return $stmt->execute([
            "id"=>$id
        ]);
    }

}