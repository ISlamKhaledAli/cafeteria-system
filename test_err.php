<?php
require 'config/Database.php';
require 'models/Order.php';
$o = new Order();
$result = $o->createOrder(5000, 'Lobby', '', 100);
if ($result === false) {
    echo "Returned false\n";
} else {
    echo "Returned ID: " . $result . "\n";
}
