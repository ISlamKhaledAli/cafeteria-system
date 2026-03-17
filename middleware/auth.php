<?php

class AuthMiddleware {

    public static function checkLogin() {
        if (!isset($_SESSION['user'])) {
            header("Location: /PHP/cafeteria-system/login");
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