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

    public function confirmOrder() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);
        
        if (!$data) {
            $this->jsonResponse(false, 'Invalid order data received.');
            return;
        }

        $userId = $_SESSION['user']['id'] ?? null;
        $roomNo = trim($data['room_no'] ?? '');
        $notes = trim($data['notes'] ?? '');
        $items = $data['items'] ?? [];

        if (!$userId || empty($items) || empty($roomNo)) {
            $this->jsonResponse(false, 'Required fields are missing.');
            return;
        }

        require_once __DIR__ . '/../models/Product.php';
        $productModel = new Product();
        
        $total_price = 0;
        $verified_items = [];

        foreach ($items as $item) {
            $realProduct = $productModel->getProductById($item['id']);
            
            if ($realProduct && $realProduct['is_available']) {
                $realPrice = (float) $realProduct['price'];
                $quantity = (int) $item['quantity'];
                
                if ($quantity > 0) {
                    $total_price += ($realPrice * $quantity);
                    $verified_items[] = [
                        'id' => $item['id'],
                        'quantity' => $quantity,
                        'price' => $realPrice
                    ];
                }
            }
        }

        if (empty($verified_items)) {
            $this->jsonResponse(false, 'Invalid items in the cart.');
            return;
        }

        $orderId = $this->orderModel->createOrder($userId, $roomNo, $notes, $total_price);

        if ($orderId) {
            $added = $this->orderItemModel->addItems($orderId, $verified_items);
            if ($added === true) {
                $this->jsonResponse(true, 'Order confirmed successfully!', ['order_id' => $orderId]);
            } else {
                $this->jsonResponse(false, 'Order created but failed to add items.');
            }
        } else {
            $this->jsonResponse(false, 'Critical error: Failed to generate order.');
        }
    }

    public function myOrders() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) {
            redirect('index.php?page=login');
        }

        $orders = $this->orderModel->getOrdersByUserId($userId);
        
        foreach ($orders as &$order) {
            $order['items'] = $this->orderItemModel->getItemsByOrderId($order['id']);
        }
        
        require_once BASE_PATH . '/views/user/my-orders.php';
    }

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