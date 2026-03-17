<?php

require_once __DIR__."/../models/User.php";

class AuthController {

    private $userModel;

    public function __construct(){

        session_start();

        $this->userModel = new User();
    }

    public function login(){

        if($_SERVER['REQUEST_METHOD']=="POST"){

            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->findUserByEmail($email);

            if($user && password_verify($password,$user['password'])){

                $_SESSION['user']=$user;

                header("Location: /");
                exit;
            }

            $error="Invalid Email or Password";
        }

        require __DIR__."/../views/auth/login.php";
    }

    public function register(){

        if($_SERVER['REQUEST_METHOD']=="POST"){

            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
            $room = $_POST['room'];
            $extension = $_POST['extension'];
            $role = "user";

            $imageName = $_FILES['image']['name'];
            $tmp = $_FILES['image']['tmp_name'];

            move_uploaded_file(
            $tmp,
            "uploads/users/".$imageName
            );

            $this->userModel->createUser([
            "name"=>$name,
            "email"=>$email,
            "password"=>$password,
            "room"=>$room,
            "extension"=>$extension,
            "role"=>$role,
            "image"=>$imageName
            ]);

            header("Location: /login");
            exit;
        }

        require __DIR__."/../views/auth/register.php";
    }

    public function logout(){

        session_destroy();

        header("Location: /login");
        exit;
    }

}