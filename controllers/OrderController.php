<?php

require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/OrderItem.php';

class OrderController {
    private $orderModel;
    private $orderItemModel;

    public function __construct() {
        $this->orderModel = new Order();
        $this->orderItemModel = new OrderItem();
    }

    /**
     * Confirm a new order
     * Expects JSON input via POST
     */
    public function confirmOrder() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        // Initialize session if not started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Get user ID from session (fallback to dummy for now if not set)
        $userId = $_SESSION['user_id'] ?? 1; 

        // Get POST data
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'No data received']);
            return;
        }

        $room_no = $data['room_no'] ?? '';
        $notes = $data['notes'] ?? '';
        $total = $data['total'] ?? 0;
        $items = $data['items'] ?? [];

        if (empty($room_no) || empty($items)) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            return;
        }

        // Start Transaction (using mysqli directly from model's DB connection would be better, 
        // but since models create their own connections, we'll assume the connection is shared or handled)
        // For simplicity with the provided db() function, we'll just proceed.
        
        $orderId = $this->orderModel->createOrder($userId, $room_no, $notes, $total);

        if ($orderId) {
            foreach ($items as $item) {
                $this->orderItemModel->addOrderItem(
                    $orderId, 
                    $item['id'], 
                    $item['quantity'], 
                    $item['price']
                );
            }

            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'order_id' => $orderId]);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Failed to create order']);
        }
    }

    /**
     * Get orders for the current user
     */
    public function getUserOrders() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user_id'] ?? 1;
        $orders = $this->orderModel->getOrdersByUser($userId);
        
        // Optionally attach items to each order
        foreach ($orders as &$order) {
            $order['items'] = $this->orderItemModel->getOrderItems($order['id']);
        }

        return $orders;
    }
}
