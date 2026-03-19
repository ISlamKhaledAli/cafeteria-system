<?php
require_once __DIR__ . '/../config/Database.php';

class OrderItem {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

   
    public function addItems($orderId, $items) {
        $query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        
        try {
            foreach ($items as $item) {
                $stmt->execute([
                    $orderId, 
                    $item['id'], 
                    $item['quantity'], 
                    $item['price']
                ]);
            }
            return true;
        } catch (PDOException $e) {
            error_log("Error adding order items: " . $e->getMessage());
            return false;
        }
    }

    
    public function getItemsByOrderId($orderId) {
        $query = "SELECT oi.*, p.name, p.image 
                  FROM order_items oi 
                  JOIN products p ON oi.product_id = p.id 
                  WHERE oi.order_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$orderId]);
        return $stmt->fetchAll();
    }
}
?>
