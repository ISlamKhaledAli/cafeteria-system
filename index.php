<?php
/**
 * Main Entry Point - Cafeteria System (Fixed - No Conflicts)
 */

// Error Reporting (Development - Disabled for Production)
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Start Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define BASE_PATH
define('BASE_PATH', __DIR__);

// Core Requirements
require_once BASE_PATH . '/config/Database.php';
require_once BASE_PATH . '/middleware/auth.php';
require_once BASE_PATH . '/controllers/AuthController.php';
require_once BASE_PATH . '/controllers/UserController.php';
require_once BASE_PATH . '/controllers/ProductController.php';
require_once BASE_PATH . '/controllers/OrderController.php';
require_once BASE_PATH . '/controllers/ReportController.php';
require_once BASE_PATH . '/controllers/CategoryController.php';
require_once BASE_PATH . '/controllers/RoomController.php';
require_once BASE_PATH . '/controllers/AdminOrderController.php';

// Routing
$page = $_GET['page'] ?? 'home';

// Helper function
function redirect($url) {
    header("Location: " . $url);
    exit;
}

// Instantiate main controllers as needed
$authController = new AuthController();
$productController = new ProductController();
$userController = new UserController();
$orderController = new OrderController();
$adminOrderController = new AdminOrderController();

switch ($page) {
    // Auth Routes
    case 'login':
        $authController->login();
        break;
    case 'register':
        $authController->register();
        break;
    case 'forget-password':
        $authController->forgetPassword();
        break;
    case 'logout':
        $authController->logout();
        break;

    // User Routes (Protected)
    case 'home':
    case 'cart':
    case 'my-orders':
        AuthMiddleware::checkUser();
        if ($page === 'my-orders') {
            $orderController->myOrders();
        } else {
            require_once BASE_PATH . '/views/user/' . $page . '.php';
        }
        break;
    case 'confirm-order':
        AuthMiddleware::checkUser();
        $orderController->confirmOrder();
        break;

    // Admin Routes (Protected)
    case 'admin-dashboard':
        AuthMiddleware::checkAdmin();
        (new ReportController())->dashboard();
        break;
    case 'admin-users':
        AuthMiddleware::checkAdmin();
        $userController->listUsers();
        break;
    case 'admin-add-user':
        AuthMiddleware::checkAdmin();
        $userController->addUser();
        break;
    case 'admin-edit-user':
        AuthMiddleware::checkAdmin();
        $id = $_GET['id'] ?? null;
        if (!$id) {
            redirect('index.php?page=admin-users');
        }
        $userController->editUser($id);
        break;
    case 'admin-delete-user':
        AuthMiddleware::checkAdmin();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $userController->deleteUser($id);
        }
        redirect('index.php?page=admin-users');
        break;
    case 'admin-products':
        AuthMiddleware::checkAdmin();
        $productController->index();
        break;
    case 'admin-add-product':
        AuthMiddleware::checkAdmin();
        $productController->create();
        break;
    case 'admin-store-product':
        AuthMiddleware::checkAdmin();
        $productController->store();
        break;
    case 'admin-edit-product':
        AuthMiddleware::checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productController->update();
        } else {
            $productController->edit();
        }
        break;
    case 'admin-delete-product':
        AuthMiddleware::checkAdmin();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $productController->delete($id);
        }
        redirect('index.php?page=admin-products');
        break;
    case 'admin-orders':
        AuthMiddleware::checkAdmin();
        $adminOrderController->index();
        break;
    case 'admin-update-order-status':
        AuthMiddleware::checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminOrderController->updateStatus();
        } else {
            redirect('index.php?page=admin-orders');
        }
        break;
    case 'admin-checks':
        AuthMiddleware::checkAdmin();
        $adminOrderController->checks();
        break;
    case 'admin-categories':
        AuthMiddleware::checkAdmin();
        (new CategoryController())->index();
        break;
    case 'admin-add-category':
        AuthMiddleware::checkAdmin();
        (new CategoryController())->store();
        break;
    case 'admin-delete-category':
        AuthMiddleware::checkAdmin();
        (new CategoryController())->delete();
        break;
    case 'admin-rooms':
        AuthMiddleware::checkAdmin();
        (new RoomController())->index();
        break;
    case 'admin-add-room':
        AuthMiddleware::checkAdmin();
        (new RoomController())->store();
        break;
    case 'admin-edit-room':
        AuthMiddleware::checkAdmin();
        (new RoomController())->update();
        break;
    case 'admin-delete-room':
        AuthMiddleware::checkAdmin();
        (new RoomController())->delete();
        break;

    // Default / 404
    default:
        if (!file_exists(BASE_PATH . '/views/' . $page . '.php')) {
            http_response_code(404);
            require_once BASE_PATH . '/views/404.php';
        } else {
            // Guest access to home or auth
            if (in_array($page, ['home', 'login', 'register'])) {
                require_once BASE_PATH . '/views/' . $page . '.php';
            } else {
                http_response_code(404);
                require_once BASE_PATH . '/views/404.php';
            }
        }
        break;
}
?>

