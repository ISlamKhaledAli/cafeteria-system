<?php
/**
 * Database Seeder - Cafeteria System (Fixed)
 */
require_once 'config/Database.php';
$db = Database::getInstance()->getConnection();

try {
    // Clear data
    $db->exec("SET FOREIGN_KEY_CHECKS = 0");
    $db->exec("TRUNCATE TABLE products");
    $db->exec("TRUNCATE TABLE categories");
    $db->exec("SET FOREIGN_KEY_CHECKS = 1");

    // Insert Categories
    $categories = ['Coffee', 'Tea', 'Snacks', 'Juice'];
    $cat_stmt = $db->prepare("INSERT INTO categories (name) VALUES (?)");
    foreach ($categories as $cat) {
        $cat_stmt->execute([$cat]);
    }
    echo "Categories seeded successfully.\n";

    // Get Category IDs
$cats = $db->query("SELECT id, name FROM categories")->fetchAll(PDO::FETCH_ASSOC);
$cat_ids = [];
foreach ($cats as $cat) {
    $cat_ids[$cat['name']] = $cat['id'];
}

    // Insert Products
    $products = [
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
    throw new Exception("Error seeding database: " . $e->getMessage());
}
?>

