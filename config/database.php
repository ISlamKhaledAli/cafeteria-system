<?php
class Database {
    // المتغير ده هيشيل الـ Instance الوحيد بتاعنا
    private static $instance = null;
    private $connection;
    private $host = "localhost";
    private $username = "mostafamohamed";
    private $password = "123456";
    private $database = "cafeteria";


    // الـ Constructor private عشان نمنع إنشاء كائن جديد من بره الكلاس (استخدام new)
    private function __construct() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
        
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    // بنمنع الـ Clone عشان محدش ينسخ الكائن ده
    private function __clone() {}

    // الدالة دي هي البوابة الوحيدة اللي بنجيب منها الاتصال
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // دالة بترجع الاتصال الفعلي عشان نستخدمه في الـ Queries
    public function getConnection() {
        return $this->connection;
    }
}
?>