<?php
require_once __DIR__ . '/../config/Database.php';

class Order {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createOrder($userId, $roomNo, $notes, $total) {
        try {
            $query = "INSERT INTO orders (user_id, room_no, notes, total_price, status, created_at) 
                      VALUES (:user_id, :room_no, :notes, :total_price, 'processing', NOW())";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':user_id' => $userId,
                ':room_no' => $roomNo,
                ':notes' => $notes,
                ':total_price' => $total
            ]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            try {
                $query = "INSERT INTO orders (user_id, room_no, notes, total, status, created_at) 
                          VALUES (:user_id, :room_no, :notes, :total, 'processing', NOW())";
                $stmt = $this->db->prepare($query);
                $stmt->execute([
                    ':user_id' => $userId,
                    ':room_no' => $roomNo,
                    ':notes' => $notes,
                    ':total' => $total
                ]);
                return $this->db->lastInsertId();
            } catch (PDOException $e2) {
                return "ERROR:" . $e2->getMessage() . " | " . $e->getMessage();
            }
        }
    }

    public function getOrdersByUserId($userId) {
        $query = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function updateOrderStatus($orderId, $status) {
        $query = "UPDATE orders SET status = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$status, $orderId]);
    }

    public function getAllOrders() {
        $query = "SELECT o.*, u.name AS user_name, u.email AS user_email
                  FROM orders o
                  JOIN users u ON u.id = o.user_id
                  ORDER BY o.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrdersBetweenDates($startDate = null, $endDate = null) {
        $where = [];
        $params = [];

        if (!empty($startDate)) {
            $where[] = "DATE(o.created_at) >= :start_date";
            $params[':start_date'] = $startDate;
        }
        if (!empty($endDate)) {
            $where[] = "DATE(o.created_at) <= :end_date";
            $params[':end_date'] = $endDate;
        }

        $whereSql = '';
        if (!empty($where)) {
            $whereSql = 'WHERE ' . implode(' AND ', $where);
        }

        $query = "SELECT o.*, u.name AS user_name, u.email AS user_email
                  FROM orders o
                  JOIN users u ON u.id = o.user_id
                  {$whereSql}
                  ORDER BY o.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
