<?php
/**
 * Database Seeder - Cafeteria System
 * Populates categories and products for testing.
 */
require_once 'config/Database.php';
$db = Database::getInstance()->getConnection();

try {
<<<<<<< HEAD
    // 1. Clear existing data (optional, but good for clean state)
    $db->exec("SET FOREIGN_KEY_CHECKS = 0");
=======
     $db->exec("SET FOREIGN_KEY_CHECKS = 0");
>>>>>>> 0289bb93717993938ae4d7f277d25ea1433930e8
    $db->exec("TRUNCATE TABLE products");
    $db->exec("TRUNCATE TABLE categories");
    $db->exec("SET FOREIGN_KEY_CHECKS = 1");

<<<<<<< HEAD
    // 2. Insert Categories
    $categories = ['Coffee', 'Tea', 'Snacks', 'Juice'];
=======
     $categories = ['Coffee', 'Tea', 'Snacks', 'Juice'];
>>>>>>> 0289bb93717993938ae4d7f277d25ea1433930e8
    $cat_stmt = $db->prepare("INSERT INTO categories (name) VALUES (?)");
    foreach ($categories as $cat) {
        $cat_stmt->execute([$cat]);
    }
    echo "Categories seeded successfully.\n";

<<<<<<< HEAD
    // 3. Get Category IDs
    $cat_ids = $db->query("SELECT id, name FROM categories")->fetchAll(PDO::FETCH_KEY_PAIR);

    // 4. Insert Products
    $products = [
=======
     $cat_ids = $db->query("SELECT id, name FROM categories")->fetchAll(PDO::FETCH_KEY_PAIR);

     $products = [
>>>>>>> 0289bb93717993938ae4d7f277d25ea1433930e8
        ['Espresso', 2.50, $cat_ids['Coffee'], 'espresso.jpg'],
        ['Cappuccino', 3.50, $cat_ids['Coffee'], 'cappuccino.jpg'],
        ['Latte Macchiato', 4.00, $cat_ids['Coffee'], 'latte.jpg'],
        ['Green Tea', 2.00, $cat_ids['Tea'], 'greentea.jpg'],
        ['English Breakfast', 2.25, $cat_ids['Tea'], 'tea.jpg'],
        ['Chocolate Muffin', 3.00, $cat_ids['Snacks'], 'muffin.jpg'],
        ['Butter Croissant', 2.50, $cat_ids['Snacks'], 'croissant.jpg'],
        ['Fresh Orange Juice', 3.50, $cat_ids['Juice'], 'orange_juice.jpg']
    ];

    $prod_stmt = $db->prepare("INSERT INTO products (name, price, category_id, image) VALUES (?, ?, ?, ?)");
    foreach ($products as $prod) {
        $prod_stmt->execute($prod);
    }
    echo "Products seeded successfully.\n";

} catch (Exception $e) {
    die("Error seeding database: " . $e->getMessage());
}
?>
