<?php

function db(){

$conn = new mysqli("localhost","root","","cafeteria");

if($conn->connect_error){
die("Connection failed");
}

return $conn;

}

?>