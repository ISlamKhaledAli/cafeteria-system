<?php

require_once __DIR__ . '/../config/Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllUsers() {
        $query = "SELECT * FROM users";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findUserByEmail($email){
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(["email"=>$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($data) {
        $query = "INSERT INTO users (name, email, password, room, ext, image, role) VALUES (:name, :email, :password, :room, :ext, :image, :role)";
        $stmt = $this->db->prepare($query);
        
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        
        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':password', $hashedPassword);
        $stmt->bindValue(':room', $data['room']);
        $stmt->bindValue(':ext', $data['ext']);
        $stmt->bindValue(':image', $data['image']);
        $stmt->bindValue(':role', $data['role']);
        
        return $stmt->execute();
    }

    public function updateUser($id, $data) {
        $fields = "";
        $values = [':id' => $id];

        foreach ($data as $key => $value) {
            if ($key === 'password') {
                if (!empty($value)) {
                    $value = password_hash($value, PASSWORD_DEFAULT);
                } else {
                    continue;
                }
            }
            
            $fields .= "$key = :$key, ";
            $values[":$key"] = $value;
        }

        $fields = rtrim($fields, ", ");
        
        $query = "UPDATE users SET $fields WHERE id = :id";
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute($values);
    }

    public function deleteUser($id) {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}
?>
