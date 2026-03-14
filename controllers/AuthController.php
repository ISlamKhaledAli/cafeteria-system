<?php

require_once "config/database.php";
require_once "models/User.php";

class AuthController {

    private $user;

    public function __construct(){

        session_start();

        $db = new Database();
        $conn = $db->connect();

        $this->user = new User($conn);

    }

    public function login(){

        if($_SERVER['REQUEST_METHOD'] == "POST"){

            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->user->findByEmail($email);

            if($user && password_verify($password,$user['password'])){

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];

                header("Location: dashboard.php");
                exit();

            }else{

                echo "Invalid email or password";

            }

        }

        require "views/auth/login.php";

    }

}