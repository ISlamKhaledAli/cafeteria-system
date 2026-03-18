<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// ==========================================
// 1. Require Middleware & Controllers
// ==========================================
require_once __DIR__ . '/middleware/auth.php';
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/ProductController.php';
require_once __DIR__ . '/controllers/OrderController.php'; // كنترولر الطلبات (Dev 4)
// require_once __DIR__ . '/controllers/AdminOrderController.php'; // (Dev 5) ضفها لما تدمج كوده

// ==========================================
// 2. Setup Routing Variables
// ==========================================
$request = $_SERVER['REQUEST_URI'] ?? '/';
$basePath = '/PHP/cafeteria-system'; 
$route = str_replace($basePath, '', $request);
$route = parse_url($route, PHP_URL_PATH);
$route = rtrim($route, '/');

// Instantiate Controllers
$userController = new UserController();
$authController = new AuthController();
$orderController = new OrderController();

// ==========================================
// 3. Routing Switch
// ==========================================
switch ($route) {
    // ------------------------------------------
    // Auth Routes (Dev 1)
    // ------------------------------------------
    case '/login':
        $authController->login();
        break;
    case '/register':
        $authController->register();
        break;
    case '/logout':
        $authController->logout();
        break;

    // ------------------------------------------
    // Admin: Users Management (Dev 3)
    // ------------------------------------------
    case '/admin/users':
        AuthMiddleware::checkAdmin();
        $userController->listUsers();
        break;
        
    case '/admin/add-user':
        AuthMiddleware::checkAdmin();
        $userController->addUser();
        break;

    case '/admin/edit-user':
        AuthMiddleware::checkAdmin();
        $id = $_GET['id'] ?? null;
        if ($id) $userController->editUser($id);
        else echo "Error: User ID is missing!";
        break;

    case '/admin/delete-user':
        AuthMiddleware::checkAdmin();
        $id = $_GET['id'] ?? null;
        if ($id) $userController->deleteUser($id);
        else echo "Error: User ID is missing!";
        break;
    
    // ------------------------------------------
    // Admin: Products Management (Dev 2)
    // ------------------------------------------
    case '/admin/products':
        AuthMiddleware::checkAdmin();
        $controller = new ProductController();
        $controller->index();
        break;

    case '/admin/add-product':
        AuthMiddleware::checkAdmin();
        $controller = new ProductController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->store();
        } else {
            $controller->create();
        }
        break;

    case '/admin/edit-product':
        AuthMiddleware::checkAdmin();
        $controller = new ProductController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->update();
        } else {
            $controller->edit();
        }
        break;

    case '/admin/delete-product':
        AuthMiddleware::checkAdmin();
        $controller = new ProductController();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $controller->delete($id);
        } else {
            header("Location: $basePath/admin/products");
        }
        break;

    // ------------------------------------------
    // Admin: Orders & Checks (Dev 5)
    // ------------------------------------------
    case '/admin/orders':
        AuthMiddleware::checkAdmin();
        // $adminOrderController->index();
        require_once __DIR__ . '/views/admin/orders.php';
        break;

    case '/admin/checks':
        AuthMiddleware::checkAdmin();
        // $reportController->index();
        require_once __DIR__ . '/views/admin/checks.php';
        break;

    // ------------------------------------------
    // User: Ordering System (Dev 4)
    // ------------------------------------------
    case '/home':
        AuthMiddleware::checkLogin();
        require_once __DIR__ . '/views/user/home.php';
        break;

    case '/cart':
        AuthMiddleware::checkLogin();
        require_once __DIR__ . '/views/user/cart.php';
        break;

    case '/my-orders':
        AuthMiddleware::checkLogin();
        require_once __DIR__ . '/views/user/my-orders.php';
        break;

    case '/confirmOrder':
        // هذا المسار يتم استدعاؤه بواسطة JavaScript (Fetch API) من ملف cart.js
        AuthMiddleware::checkLogin();
        $orderController->confirmOrder();
        break;

    // ------------------------------------------
    // Root Route (Redirect based on Role)
    // ------------------------------------------
    case '':
    case '/':
        AuthMiddleware::checkLogin();
        // توجيه ذكي بناءً على نوع المستخدم
        if ($_SESSION['user']['role'] === 'admin') {
            header("Location: $basePath/admin/users"); // يمكن تغييرها لـ /admin/orders لاحقاً
        } else {
            header("Location: $basePath/home");
        }
        exit();

    // ------------------------------------------
    // 404 Not Found
    // ------------------------------------------
    default:
        http_response_code(404);
        require_once __DIR__ . '/layouts/header.php';
        echo "<div class='container text-center mt-5 pt-5' style='min-height: 60vh;'>";
        echo "<h1 class='display-1 fw-bold' style='color: #d97706;'>404</h1>";
        echo "<h3 class='text-muted'>Page Not Found</h3>";
        echo "<p class='text-muted mb-4'>The page you are looking for doesn't exist or has been moved.</p>";
        echo "<a href='$basePath/' class='btn text-white' style='background-color: #d97706;'>Return to Home</a>";
        echo "</div>";
        require_once __DIR__ . '/layouts/footer.php';
        break;
}