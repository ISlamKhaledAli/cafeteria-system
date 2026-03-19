<?php
require_once __DIR__ . '/config/Database.php';
$db = Database::getInstance()->getConnection();
$tables = ['orders', 'order_items', 'products', 'users', 'categories'];
foreach($tables as $table) {
    echo "--- $table ---\n";
    try {
        $stmt = $db->query("DESCRIBE $table");
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "{$row['Field']} - {$row['Type']}\n";
        }
    } catch(Exception $e) { echo "Error: " . $e->getMessage() . "\n"; }
}
