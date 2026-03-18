<?php
/**
 * Auth Middleware - Cafeteria System
 * FIXED: Redirect to correct routing format (index.php?page=login).
 */

class AuthMiddleware {

    public static function checkLogin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            // FIXED: Redirection path
            header("Location: index.php?page=login");
            exit;
        }
    }

    public static function checkAdmin() {
        self::checkLogin();
        
        if ($_SESSION['user']['role'] !== 'admin') {
            http_response_code(403);
            die("<h1 style='text-align:center; color:red; margin-top:50px;'>403 Forbidden: Admins Only!</h1>");
        }
    }

}
?>