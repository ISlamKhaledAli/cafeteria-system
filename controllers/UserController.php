<?php
require_once __DIR__ . '/../models/User.php';

class UserController {
    private $userModel;

    public function __construct() {
        // بنعمل Instance من الـ Model عشان نستخدم دواله
        $this->userModel = new User();
    }

    // 1. عرض كل المستخدمين
    public function listUsers() {
        $users = $this->userModel->getAllUsers();
        // بنستدعي الـ View وبنمررله البيانات
        require_once __DIR__ . '/../views/admin/users.php';
    }

    // 2. إضافة مستخدم جديد (بتعالج الـ Form لما تتبعت)
    public function addUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name'     => $_POST['name'],
                'email'    => $_POST['email'],
                'password' => $_POST['password'],
                'room'     => $_POST['room'],
                'ext'      => $_POST['ext'],
                'role'     => $_POST['role'] ?? 'user'
            ];

            // معالجة رفع الصورة
            $data['image'] = $this->uploadImage($_FILES['image']);

            if ($this->userModel->createUser($data)) {
                // لو الإضافة نجحت، بنرجعه لصفحة العرض
                header("Location: /PHP/cafeteria-system/admin/users");
                exit();
            } else {
                echo "Error adding user!";
            }
        } else {
            // لو الـ Request مش POST، بنعرض فورم الإضافة
            require_once __DIR__ . '/../views/admin/add-user.php';
        }
    }

    // 3. تعديل مستخدم
    public function editUser($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name'  => $_POST['name'],
                'email' => $_POST['email'],
                'room'  => $_POST['room'],
                'ext'   => $_POST['ext'],
                'role'  => $_POST['role']
            ];

            // لو كتب باسورد جديد، بنضيفه للـ Data عشان يتحدث
            if (!empty($_POST['password'])) {
                $data['password'] = $_POST['password'];
            }

            // لو رفع صورة جديدة
            if (!empty($_FILES['image']['name'])) {
                $data['image'] = $this->uploadImage($_FILES['image']);
            }

            if ($this->userModel->updateUser($id, $data)) {
                header("Location: /PHP/cafeteria-system/admin/users");
                exit();
            }
        } else {
            // جلب بيانات المستخدم القديمة لعرضها في الفورم
            $user = $this->userModel->getUserById($id);
            require_once __DIR__ . '/../views/admin/edit-user.php';
        }
    }

    // 4. حذف مستخدم
    public function deleteUser($id) {
        $this->userModel->deleteUser($id);
        header("Location: /PHP/cafeteria-system/admin/users");
        exit();
    }

    // --- Helper Method لرفع الصور ---
    private function uploadImage($file) {
        // لو مفيش صورة اترفع، بنرجع صورة افتراضية (ممكن تجهز صورة اسمها default.png)
        if (empty($file['name'])) {
            return 'default.png'; 
        }

        $targetDir = __DIR__ . '/../uploads/users/';
        
        // التأكد من وجود الفولدر، ولو مش موجود ننشئه
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // إنشاء اسم فريد للصورة عشان مفيش صورتين يمسحوا بعض
        $fileName = time() . '_' . basename($file["name"]);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
            return $fileName; // بنرجع اسم الصورة بس عشان يتخزن في الداتا بيز
        }

        return 'default.png'; // في حالة الفشل
    }
}
?>