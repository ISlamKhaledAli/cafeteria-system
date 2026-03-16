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

require_once __DIR__ . '/../config/database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllUsers() {
        $query = "SELECT * FROM users";
        $result = $this->db->query($query);
        
        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
        return $users;
    }

    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function createUser($data) {
        $query = "INSERT INTO users (name, email, password, room, ext, image, role) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        
        $stmt->bind_param("sssssss", 
            $data['name'], 
            $data['email'], 
            $hashedPassword, 
            $data['room'], 
            $data['ext'], 
            $data['image'], 
            $data['role']
        );
        
        return $stmt->execute();
    }

    public function updateUser($id, $data) {
        $fields = "";
        $values = [];
        $types = "";

        foreach ($data as $key => $value) {
            if ($key === 'password') {
                $value = password_hash($value, PASSWORD_DEFAULT);
            }
            
            $fields .= "$key = ?, ";
            $values[] = $value;
            $types .= "s"; 
        }

        $fields = rtrim($fields, ", ");
        
        $query = "UPDATE users SET $fields WHERE id = ?";
        $stmt = $this->db->prepare($query);
        
        $values[] = $id;
        $types .= "i";
        
        $stmt->bind_param($types, ...$values);
        
        return $stmt->execute();
    }

    public function deleteUser($id) {
        $query = "DELETE FROM users WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }
}
?>

