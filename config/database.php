<?php

require_once __DIR__ . '/Database.php';

function db(){

static $conn = null;

if($conn instanceof mysqli){
return $conn;
}

$host = getenv('DB_HOST') ?: "localhost";
$user = getenv('DB_USER') ?: "root";
$pass = getenv('DB_PASS') ?: "";
$name = getenv('DB_NAME') ?: "cafeteria";

$conn = new mysqli($host, $user, $pass, $name);

if($conn->connect_error){
die("Connection failed");
}

return $conn;

}

function db_pdo(){
return \Database::getInstance()->getConnection();
}

?>