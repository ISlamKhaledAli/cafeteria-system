<?php
require_once __DIR__ . '/../config/Database.php';

class Order {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Create a new order in the 'orders' table.
     * FIXED: Columns renamed to match schema (total_price, room_no, created_at)
     * FIXED: Status value set to lowercase 'processing' to match ENUM
     */
    public function createOrder($userId, $roomNo, $notes, $total) {
        // Correct Schema: user_id, total_price, status, notes, room_no, created_at
        $query = "INSERT INTO orders (user_id, room_no, notes, total_price, status) VALUES (?, ?, ?, ?, 'processing')";
        $stmt = $this->db->prepare($query);
        
        try {
            if ($stmt->execute([$userId, $roomNo, $notes, $total])) {
                return $this->db->lastInsertId();
            }
        } catch (PDOException $e) {
            error_log("Error creating order: " . $e->getMessage());
        }
        return false;
    }

    /**
     * Retrieve all orders for a specific user.
     * FIXED: ORDER BY created_at DESC
     */
    public function getOrdersByUserId($userId) {
        $query = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    /**
     * Update order status.
     * Statuses: processing, out_for_delivery, delivered, canceled
     */
    public function updateOrderStatus($orderId, $status) {
        $query = "UPDATE orders SET status = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$status, $orderId]);
    }
}
?>
