<?php
require_once __DIR__ . '/../models/User.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function listUsers() {
        $users = $this->userModel->getAllUsers();
        require_once __DIR__ . '/../views/admin/users.php';
    }

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

            if ($this->userModel->isEmailExists($_POST['email'])) {
                $_SESSION['error'] = "This email is already registered!";
                header("Location: /PHP/cafeteria-system/admin/add-user");
                exit();
            }

            $data['image'] = $this->uploadImage($_FILES['image']);

            if ($this->userModel->createUser($data)) {
                header("Location: /PHP/cafeteria-system/admin/users");
                exit();
            } else {
                echo "Error adding user!";
            }
        } else {
            require_once __DIR__ . '/../views/admin/add-user.php';
        }
    }

    public function editUser($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name'  => $_POST['name'],
                'email' => $_POST['email'],
                'room'  => $_POST['room'],
                'ext'   => $_POST['ext'],
                'role'  => $_POST['role']
            ];

            if (!empty($_POST['password'])) {
                $data['password'] = $_POST['password'];
            }

            $oldUser = $this->userModel->getUserById($id);

            if (!empty($_FILES['image']['name'])) {
                $newImage = $this->uploadImage($_FILES['image']);
                
                if ($newImage !== 'default.png') {
                    $data['image'] = $newImage;
                    
                    if ($oldUser['image'] !== 'default.png' && file_exists(__DIR__ . '/../uploads/users/' . $oldUser['image'])) {
                        unlink(__DIR__ . '/../uploads/users/' . $oldUser['image']);
                    }
                }
            }

            if ($this->userModel->updateUser($id, $data)) {
                header("Location: /PHP/cafeteria-system/admin/users");
                exit();
            }
        } else {
            $user = $this->userModel->getUserById($id);
            require_once __DIR__ . '/../views/admin/edit-user.php';
        }
    }

    public function deleteUser($id) {
        $user = $this->userModel->getUserById($id);

        if ($user && $user['image'] !== 'default.png') {
            $imagePath = __DIR__ . '/../uploads/users/' . $user['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $this->userModel->deleteUser($id);
        header("Location: /PHP/cafeteria-system/admin/users");
        exit();
    }

    private function uploadImage($file) {
        if (!isset($file['error']) || is_array($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            // return 'default.png';
            die("Debug: الصورة لم تصل للـ Backend بشكل صحيح. تأكد من وجود enctype في الفورم.");
        }

        if ($file['size'] > 2097152) {
            // return 'default.png'; 
            die("Debug: حجم الصورة أكبر من 2 ميجا.");        
        }

        $allowedTypes = [
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp'=> 'image/webp'
        ];
        
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        $ext = array_search($mime, $allowedTypes, true);

        if ($ext === false) {
            die("Debug: الملف المرفوع ليس صورة مدعومة. الـ MIME المقروء هو: " . $mime);
            // return 'default.png'; 
        }

        $targetDir = __DIR__ . '/../uploads/users/';
        if (!is_dir($targetDir)) {
            // mkdir($targetDir, 0777, true);
            if (!mkdir($targetDir, 0777, true)) {
                die("Debug: فشل في إنشاء مجلد uploads/users/. تأكد من صلاحيات Ubuntu.");
            }
        }

        $fileName = time() . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
            return $fileName;
        }
        else {
            die("Debug: فشل في نقل الصورة (move_uploaded_file). الأباتشي لا يملك صلاحيات الكتابة في المجلد!");
        }

        return 'default.png';  
    }
}
?>