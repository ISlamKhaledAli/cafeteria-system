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
     * Handle the order confirmation from the cart.
     * FIXED: Ensure variable names align with fixed Model methods.
     */
    public function confirmOrder() {
        // Get raw POST data (JSON)
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!$data) {
            $this->jsonResponse(false, 'Invalid order data received.');
        }

        $userId = $data['user_id'] ?? null;
        $roomNo = $data['room_no'] ?? ''; // Maps to room_no in DB
        $notes = $data['notes'] ?? '';
        $items = $data['items'] ?? [];

        if (!$userId || !$roomNo || empty($items)) {
            $this->jsonResponse(false, 'Required fields are missing.');
        }

        // Calculate total price server-side
        $total_price = 0;
        foreach ($items as $item) {
            $total_price += $item['price'] * $item['quantity'];
        }

        // Create the Order entry (matches total_price, room_no)
        $orderId = $this->orderModel->createOrder($userId, $roomNo, $notes, $total_price);
        
        if ($orderId) {
            // Add items to order_items table
            if ($this->orderItemModel->addItems($orderId, $items)) {
                $this->jsonResponse(true, 'Order confirmed successfully!', ['order_id' => $orderId]);
            } else {
                $this->jsonResponse(false, 'Order created but failed to add items.');
            }
        } else {
            $this->jsonResponse(false, 'Critical error: Failed to generate order.');
        }
    }

    /**
     * List user orders for the "My Orders" page.
     * FIXED: Redirect to index.php?page=login
     */
    public function myOrders() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) {
            header('Location: index.php?page=login');
            exit;
        }

        $orders = $this->orderModel->getOrdersByUserId($userId);
        
        // Fetch items for each order to display in the history
        foreach ($orders as &$order) {
            $order['items'] = $this->orderItemModel->getItemsByOrderId($order['id']);
        }
        
        // Pass data to correctly path-defined view
        require_once BASE_PATH . '/views/user/my-orders.php';
    }

    /**
     * JSON helper for API responses.
     */
    private function jsonResponse($success, $message, $data = []) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => $success, 
            'message' => $message, 
            'data'    => $data
        ]);
        exit;
    }
}
?>
