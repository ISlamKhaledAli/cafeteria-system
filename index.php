<?php
// إظهار الأخطاء عشان إحنا في بيئة التطوير
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// بدء الجلسة (هنحتاجها بعدين في الـ Login)
session_start();

// استدعاء الـ Controller بتاعك
require_once __DIR__ . '/controllers/UserController.php';

// تنظيف الرابط عشان نعرف المستخدم عايز أي صفحة
// $request = $_SERVER['REQUEST_URI'];
$request = $_SERVER['REQUEST_URI'] ?? '/';

// تحديد المسار الأساسي للمشروع على الـ Localhost عندك
$basePath = '/PHP/cafeteria-system'; 

// بنشيل المسار الأساسي من الرابط عشان يتبقى لنا اسم الصفحة بس (مثال: /admin/users)
$route = str_replace($basePath, '', $request);

// لو الرابط فيه متغيرات زي ?id=1 بنفصلها عشان التوجيه يشتغل صح
$route = parse_url($route, PHP_URL_PATH);
// إزالة أي سلاش زيادة في آخر الرابط
$route = rtrim($route, '/');

// التوجيه (Routing) بناءً على الرابط
switch ($route) {
    // ------------------------------------
    // مسارات إدارة المستخدمين (Dev 3)
    // ------------------------------------
    case '/admin/users':
        $controller = new UserController();
        $controller->listUsers();
        break;
        
    case '/admin/add-user':
        $controller = new UserController();
        $controller->addUser();
        break;

    case '/admin/edit-user':
        $controller = new UserController();
        // بنأخذ الـ ID من الرابط
        $id = $_GET['id'] ?? null;
        if ($id) {
            $controller->editUser($id);
        } else {
            echo "Error: User ID is missing!";
        }
        break;

    case '/admin/delete-user':
        $controller = new UserController();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $controller->deleteUser($id);
        } else {
            echo "Error: User ID is missing!";
        }
        break;

    // ------------------------------------
    // الصفحة الرئيسية المؤقتة
    // ------------------------------------
    case '':
    case '/':
        echo "<div style='text-align:center; margin-top:50px; font-family:sans-serif;'>";
        echo "<h1>Welcome to Cafeteria System</h1>";
        echo "<a href='$basePath/admin/users' style='padding:10px 20px; background:#d97706; color:#fff; text-decoration:none; border-radius:5px;'>Go to Users Management</a>";
        echo "</div>";
        break;

    // ------------------------------------
    // صفحة خطأ 404 لو الرابط مش موجود
    // ------------------------------------
    default:
        http_response_code(404);
        echo "<h1 style='text-align:center; margin-top:50px;'>404 - Page Not Found</h1>";
        break;
}
?>