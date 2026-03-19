<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('BASE_PATH', __DIR__);

require_once BASE_PATH . '/config/Database.php';
require_once BASE_PATH . '/middleware/auth.php';

function redirect($url) {
    header("Location: " . $url);
    exit;
}

$page = $_GET['page'] ?? 'home';
$id   = $_GET['id'] ?? null;

$routes = [
    'login'           => ['controller' => 'AuthController', 'action' => 'login'],
    'register'        => ['controller' => 'AuthController', 'action' => 'register'],
    'forget-password' => ['controller' => 'AuthController', 'action' => 'forgetPassword'],
    'logout'          => ['controller' => 'AuthController', 'action' => 'logout'],

    'home'            => ['view' => 'user/home.php', 'middleware' => 'user'],
    'cart'            => ['view' => 'user/cart.php', 'middleware' => 'user'],
    'my-orders'       => ['controller' => 'OrderController', 'action' => 'myOrders', 'middleware' => 'user'],
    'confirm-order'   => ['controller' => 'OrderController', 'action' => 'confirmOrder', 'middleware' => 'user'],

    'admin-dashboard' => ['controller' => 'ReportController', 'action' => 'dashboard', 'middleware' => 'admin'],
    'admin-users'     => ['controller' => 'UserController', 'action' => 'listUsers', 'middleware' => 'admin'],
    'admin-add-user'  => ['controller' => 'UserController', 'action' => 'addUser', 'middleware' => 'admin'],
    'admin-edit-user' => ['controller' => 'UserController', 'action' => 'editUser', 'middleware' => 'admin', 'needs_id' => true, 'fallback' => 'admin-users'],
    'admin-delete-user'=>['controller' => 'UserController', 'action' => 'deleteUser', 'middleware' => 'admin', 'needs_id' => true, 'fallback' => 'admin-users'],

    'admin-products'       => ['controller' => 'ProductController', 'action' => 'index', 'middleware' => 'admin'],
    'admin-add-product'    => ['controller' => 'ProductController', 'action' => 'create', 'middleware' => 'admin'],
    'admin-store-product'  => ['controller' => 'ProductController', 'action' => 'store', 'middleware' => 'admin'],
    'admin-edit-product'   => ['controller' => 'ProductController', 'action' => 'edit', 'middleware' => 'admin'],
    'admin-delete-product' => ['controller' => 'ProductController', 'action' => 'delete', 'middleware' => 'admin', 'needs_id' => true, 'fallback' => 'admin-products'],

    'admin-categories'      => ['controller' => 'CategoryController', 'action' => 'index', 'middleware' => 'admin'],
    'admin-add-category'    => ['controller' => 'CategoryController', 'action' => 'store', 'middleware' => 'admin'],
    'admin-delete-category' => ['controller' => 'CategoryController', 'action' => 'delete', 'middleware' => 'admin'],
    'admin-rooms'           => ['controller' => 'RoomController', 'action' => 'index', 'middleware' => 'admin'],
    'admin-add-room'        => ['controller' => 'RoomController', 'action' => 'store', 'middleware' => 'admin'],
    'admin-edit-room'       => ['controller' => 'RoomController', 'action' => 'update', 'middleware' => 'admin'],
    'admin-delete-room'     => ['controller' => 'RoomController', 'action' => 'delete', 'middleware' => 'admin'],

    'admin-orders'              => ['controller' => 'AdminOrderController', 'action' => 'index', 'middleware' => 'admin'],
    'admin-update-order-status' => ['controller' => 'AdminOrderController', 'action' => 'updateStatus', 'middleware' => 'admin'],
    'admin-checks'              => ['controller' => 'AdminOrderController', 'action' => 'checks', 'middleware' => 'admin'],
];

if (!array_key_exists($page, $routes)) {
    http_response_code(404);
    require_once BASE_PATH . '/views/404.php';
    exit;
}

$route = $routes[$page];

if (isset($route['middleware'])) {
    if ($route['middleware'] === 'admin') AuthMiddleware::checkAdmin();
    if ($route['middleware'] === 'user')  AuthMiddleware::checkUser();
}

if (isset($route['view'])) {
    require_once BASE_PATH . '/views/' . $route['view'];
    exit;
}

if (isset($route['controller']) && isset($route['action'])) {
    require_once BASE_PATH . '/controllers/' . $route['controller'] . '.php';
    $controller = new $route['controller']();

    if ($page === 'admin-edit-product' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->update();
        exit;
    }
    if ($page === 'admin-update-order-status' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirect('index.php?page=admin-orders');
    }

    $action = $route['action'];

    if (isset($route['needs_id'])) {
        if (!$id) redirect('index.php?page=' . $route['fallback']);
        $controller->$action($id);
    } else {
        $controller->$action();
    }
}