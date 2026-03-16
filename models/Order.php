<?php

require_once __DIR__ . '/../config/database.php';

class Order {
    private $db;

    public function __construct() {
        $this->db = db();
    }

    public function createOrder($userId, $room, $notes, $total) {
        $stmt = $this->db->prepare("INSERT INTO orders (user_id, room_no, notes, total_price, status, order_date) VALUES (?, ?, ?, ?, 'processing', NOW())");
        $stmt->bind_param("iisd", $userId, $room, $notes, $total);
        if ($stmt->execute()) {
            return $this->db->insert_id;
        }
        return false;
    }

    public function updateStatus($orderId, $status) {
        $stmt = $this->db->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $orderId);
        return $stmt->execute();
    }

    public function getOrdersByUser($userId) {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
