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
                'name'     => $_POST['name']    ?? '',
                'email'    => $_POST['email']   ?? '',
                'password' => $_POST['password'] ?? '',
                'room_no'  => $_POST['room_no'] ?? '',
                'ext'      => $_POST['ext']     ?? '',
                'role'     => $_POST['role']    ?? 'user'
            ];

            if ($this->userModel->isEmailExists($data['email'])) {
                $_SESSION['error'] = "This email is already registered!";
                redirect('index.php?page=admin-add-user');
            }

            try {
                $data['image'] = $this->uploadImage($_FILES['image'] ?? null);
            } catch (Exception $e) {
                $_SESSION['error'] = "Image Upload Error: " . $e->getMessage();
                redirect('index.php?page=admin-add-user');
            }
            // $data['image'] = $this->uploadImage($_FILES['image'] ?? null);

            if ($this->userModel->createUser($data)) {
                $_SESSION['success'] = "User added successfully!";
                redirect('index.php?page=admin-users');
            } else {
                $_SESSION['error'] = "Error adding user!";
                redirect('index.php?page=admin-add-user');
            }
        } else {
            require_once __DIR__ . '/../views/admin/add-user.php';
        }
    }

    public function editUser($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name'    => $_POST['name']    ?? '',
                'email'   => $_POST['email']   ?? '',
                'room_no'  => $_POST['room_no'] ?? '',
                'ext'     => $_POST['ext']     ?? '',
                'role'    => $_POST['role']    ?? 'user'
            ];

            if (!empty($_POST['password'])) {
                $data['password'] = $_POST['password'];
            }

            $oldUser = $this->userModel->getUserById($id);

            // Prevent downgrading the last admin
            if ($oldUser['role'] === 'admin' && $data['role'] !== 'admin') {
                if ($this->userModel->countAdmins() <= 1) {
                    $_SESSION['error'] = "Cannot downgrade the last admin in the system!";
                    redirect("index.php?page=admin-edit-user&id=$id");
                }
            }

            if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
                try {
                    $newImage = $this->uploadImage($_FILES['image']);
                    if ($newImage && $newImage !== 'default.png') {
                        $data['image'] = $newImage;
                        // حذف الصورة القديمة إذا لم تكن الافتراضية
                        if (!empty($oldUser['image']) && $oldUser['image'] !== 'default.png') {
                            $oldPath = __DIR__ . '/../uploads/users/' . $oldUser['image'];
                            if (file_exists($oldPath)) unlink($oldPath);
                        }
                    }
                } catch (Exception $e) {
                    $_SESSION['error'] = "Image Upload Error: " . $e->getMessage();
                    redirect("index.php?page=admin-edit-user&id=$id");
                }
            }

            try {
                if ($this->userModel->updateUser($id, $data)) {
                    $_SESSION['success'] = "User updated successfully!";
                    redirect('index.php?page=admin-users');
                } else {
                    $_SESSION['error'] = "No changes were made or error occurred!";
                    redirect("index.php?page=admin-edit-user&id=$id");
                }
            } catch (PDOException $e) {
                $_SESSION['error'] = "Database Error: " . $e->getMessage();
                redirect("index.php?page=admin-edit-user&id=$id");
            }
        } else {
            $user = $this->userModel->getUserById($id);
            require_once __DIR__ . '/../views/admin/edit-user.php';
        }
    }

    public function deleteUser($id) {
        $user = $this->userModel->getUserById($id);

        if ($user && $user['role'] === 'admin') {
            if ($this->userModel->countAdmins() <= 1) {
                $_SESSION['error'] = "Cannot delete the last admin in the system!";
                redirect('index.php?page=admin-users');
            }
        }

        try {
            $this->userModel->deleteUser($id);
            if ($user && !empty($user['image']) && $user['image'] !== 'default.png') {
            $imagePath = __DIR__ . '/../uploads/users/' . $user['image'];
            if (file_exists($imagePath)) unlink($imagePath);

            $_SESSION['success'] = "User deleted successfully!";
        }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Cannot delete this user because they have existing orders!";
        }
;
        redirect('index.php?page=admin-users');
    }

    private function uploadImage($file) {
         
        if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE || empty($file['name'])) {
            return 'default.png';
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $uploadErrors = [
                UPLOAD_ERR_INI_SIZE   => 'File is larger than upload_max_filesize in php.ini.',
                UPLOAD_ERR_FORM_SIZE  => 'File exceeds MAX_FILE_SIZE in the HTML form.',
                UPLOAD_ERR_PARTIAL    => 'File was only partially uploaded.',
                UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
                UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the file upload.'
            ];
            $errorMsg = $uploadErrors[$file['error']] ?? 'Unknown upload error.';
            throw new Exception($errorMsg);
        }
        if ($file['size'] > 5242880) {
            throw new Exception("File size exceeds the 5MB limit.");
        }

        $allowedTypes = [
            'jpg'  => 'image/jpeg',
            'png'  => 'image/png',
            'gif'  => 'image/gif',
            'webp' => 'image/webp'
        ];

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime  = $finfo->file($file['tmp_name']);
        $ext   = array_search($mime, $allowedTypes, true);

        if ($ext === false) {
            throw new Exception("Invalid file type. Allowed: JPG, PNG, GIF, WEBP. Detected: $mime");
        }

        $targetDir = __DIR__ . '/../uploads/users/';

        if (!is_dir($targetDir)) {
            if (!mkdir($targetDir, 0777, true)) {
                 throw new Exception('Failed to create destination folder (uploads/users/). Check permissions.');
            }
        }

        $fileName       = time() . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            return $fileName;
        }

        throw new Exception('Failed to move uploaded file. Check folder permissions (chmod 777).');
    }
}
?>