<?php
require_once __DIR__ . '/../config/Database.php';

class Room {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllRooms() {
        $stmt = $this->db->query("SELECT * FROM rooms ORDER BY name ASC");
        return $stmt->fetchAll();
    }

    public function createRoom($name) {
        $stmt = $this->db->prepare("INSERT INTO rooms (name) VALUES (?)");
        return $stmt->execute([$name]);
    }

    public function updateRoom($id, $name) {
        $stmt = $this->db->prepare("UPDATE rooms SET name = ? WHERE id = ?");
        return $stmt->execute([$name, $id]);
    }

    public function deleteRoom($id) {
        $stmt = $this->db->prepare("DELETE FROM rooms WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
