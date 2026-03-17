<?php

require_once __DIR__ . '/../config/Database.php';

class Order {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createOrder($userId, $room, $notes, $total) {
        $stmt = $this->db->prepare("INSERT INTO orders (user_id, room_no, notes, total_price, status, order_date) VALUES (?, ?, ?, ?, 'processing', NOW())");
        if ($stmt->execute([$userId, $room, $notes, $total])) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function updateStatus($orderId, $status) {
        $stmt = $this->db->prepare("UPDATE orders SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $orderId]);
    }

    public function getOrdersByUser($userId) {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}
