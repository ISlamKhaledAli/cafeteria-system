<?php

require_once __DIR__ . '/../config/database.php';

class OrderItem {
    private $db;

    public function __construct() {
        $this->db = db();
    }

    public function addOrderItem($orderId, $productId, $qty, $price) {
        $stmt = $this->db->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $orderId, $productId, $qty, $price);
        return $stmt->execute();
    }

    public function getOrderItems($orderId) {
        $stmt = $this->db->prepare("
            SELECT oi.*, p.name as product_name 
            FROM order_items oi 
            JOIN products p ON oi.product_id = p.id 
            WHERE oi.order_id = ?
        ");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
