<?php

require_once "controllers/AuthController.php";

$auth = new AuthController();

$uri = $_SERVER['REQUEST_URI'];

if($uri=="/login"){
$auth->login();
}

elseif($uri=="/register"){
$auth->register();
}

elseif($uri=="/logout"){
$auth->logout();
}

else{
$auth->login();
}