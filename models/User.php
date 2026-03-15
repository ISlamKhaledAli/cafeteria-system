<?php
require_once __DIR__ . '/../config/database.php';

class User {
    private $db;

    public function __construct() {
        // بنجيب الاتصال باستخدام الـ Singleton اللي عملناه
        $this->db = Database::getInstance()->getConnection();
    }

    // 1. دالة جلب كل المستخدمين (هتستخدمها في عرض الجدول)
    public function getAllUsers() {
        $query = "SELECT * FROM users";
        $result = $this->db->query($query);
        
        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
        return $users;
    }

    // 2. دالة جلب مستخدم واحد بالـ ID (هتستخدمها في صفحة التعديل)
    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // مكان دوال الإضافة (Create)، التعديل (Update)، والحذف (Delete)...
    public function createUser($data) {
        $query = "INSERT INTO users (name, email, password, room, ext, image, role) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        
        // تشفير الباسورد قبل الحفظ (Best Practice)
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        
        // sssssss تعني أن الـ 7 متغيرات نوعهم String
        $stmt->bind_param("sssssss", 
            $data['name'], 
            $data['email'], 
            $hashedPassword, 
            $data['room'], 
            $data['ext'], 
            $data['image'], 
            $data['role']
        );
        
        return $stmt->execute();
    }

    /**
     * تعديل بيانات مستخدم (Update)
     * الدالة دي مصممة بطريقة "Dynamic" عشان لو حابين نعدل حقول معينة بس (مثلاً الصورة متعدلتش)
     */
    public function updateUser($id, $data) {
        $fields = "";
        $values = [];
        $types = "";

        foreach ($data as $key => $value) {
            // لو بنحدث الباسورد، لازم نشفره الأول
            if ($key === 'password') {
                $value = password_hash($value, PASSWORD_DEFAULT);
            }
            
            $fields .= "$key = ?, ";
            $values[] = $value;
            $types .= "s"; // بنفترض إن كل البيانات String للتبسيط
        }

        // إزالة آخر فاصلة ومسافة من الـ string
        $fields = rtrim($fields, ", ");
        
        $query = "UPDATE users SET $fields WHERE id = ?";
        $stmt = $this->db->prepare($query);
        
        // إضافة الـ ID في نهاية القيم ونوعه Integer (i)
        $values[] = $id;
        $types .= "i";
        
        // ربط المتغيرات ديناميكياً
        $stmt->bind_param($types, ...$values);
        
        return $stmt->execute();
    }

    /**
     * حذف مستخدم (Delete)
     */
    public function deleteUser($id) {
        $query = "DELETE FROM users WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }
}
?>