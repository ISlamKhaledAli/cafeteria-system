<?php
/**
 * User Home Page - Product Menu
 * FIXED: Dynamic Room Selection from Database and Sorting UI Hook.
 */
// Fetch dynamic rooms from existing users 
$user_db = Database::getInstance()->getConnection();
$room_stmt = $user_db->query("SELECT DISTINCT room_no FROM users WHERE room_no IS NOT NULL AND room_no != ''");
$dynamic_rooms = $room_stmt->fetchAll(PDO::FETCH_COLUMN) ?: ['101', '102', '103'];

// Room Name Mapping for user-friendly labels (Standardized)
$room_labels = [
    '101' => 'Meeting Room (101)',
    '102' => 'Office Room (102)',
    '103' => 'Conference Hall (103)',
    'Lobby' => 'Main Lobby'
];

function formatRoomLabel($room, $labels) {
    if (isset($labels[$room])) return $labels[$room];
    return is_numeric($room) ? "Room " . $room : $room;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafeteria - Refreshments Menu</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary-orange: #F59E0B; --bg-gray: #F8F7F6; --text-dark: #111827; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-gray); color: var(--text-dark); }
        .sidebar-card { border-radius: 24px; border: none; position: sticky; top: 100px; max-height: calc(100vh - 120px); display: flex; flex-direction: column; }
        .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem; }
        .animate-fade-in { animation: fadeIn 0.4s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .form-select, .form-control { border: 1px solid #E5E7EB; transition: border-color 0.2s; }
        .form-select:focus, .form-control:focus { border-color: var(--primary-orange); box-shadow: none; }
    </style>
</head>
<body>
    <?php include BASE_PATH . '/layouts/navbar.php'; ?>
    <script>window.userId = <?= json_encode($_SESSION['user']['id']) ?>;</script>

    <div class="container py-5">
        <div class="row g-5">
            <!-- Sidebar: Order Summary -->
            <div class="col-lg-4 col-xl-3 order-2 order-lg-1">
                <div class="card sidebar-card shadow-lg p-4 bg-white">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold mb-0">Order Summary</h4>
                        <span class="badge rounded-pill bg-light text-warning px-3 py-2 fw-bold" id="cart-count">0 Items</span>
                    </div>

                    <div id="cart-items-container" class="flex-grow-1 overflow-auto mb-4 pe-2" style="scrollbar-width: thin; min-height: 100px;"></div>

                    <div class="mt-auto pt-3 border-top">
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Delivery Room</label>
                            <!-- FIXED: Dynamic Room selection from DB -->
                            <select class="form-select border-0 bg-light rounded-3 py-2 shadow-sm" id="room_select">
                                <?php foreach ($dynamic_rooms as $room): ?>
                                    <option value="<?= htmlspecialchars($room) ?>">
                                        <?= htmlspecialchars(formatRoomLabel($room, $room_labels)) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Notes</label>
                            <textarea class="form-control border-0 bg-light rounded-3 shadow-sm" id="order_notes" rows="2" placeholder="e.g. Extra napkins, no sugar..."></textarea>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="text-muted fw-semibold fs-5">Total</span>
                            <h3 class="fw-bold mb-0 text-warning" id="cart-total">$0.00</h3>
                        </div>

                        <button class="btn w-100 py-3 rounded-pill fw-bold shadow-lg" onclick="window.location.href='index.php?page=cart'" id="btn-checkout" style="background-color: #F59E0B; color: white;">
                            Checkout <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main Content: Product Grid -->
            <div class="col-lg-8 col-xl-9 order-1 order-lg-2">
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <h1 class="fw-bold mb-0">Discover <span class="text-warning">Refreshments</span></h1>
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-muted small fw-bold">Sort By:</span>
                        <!-- FIXED: Sorting Dropdown with JS trigger -->
                        <select class="form-select border-0 bg-white rounded-pill px-4 shadow-sm" id="sort_products" style="width: 180px;">
                            <option value="default">Default</option>
                            <option value="price_low">Price: Low to High</option>
                            <option value="price_high">Price: High to Low</option>
                            <option value="name">A - Z</option>
                        </select>
                    </div>
                </div>
                
                <div class="product-grid" id="product-grid">
                    <?php
                    // Fetch real products from database using Model
                    require_once BASE_PATH . '/models/Product.php';
                    $productModel = new Product();
                    $products = $productModel->getAllProducts();

                    foreach ($products as $p) {
                        // Map internal schema to component variable names
                        $product = ['id' => $p['id'], 'name' => $p['product_name'], 'price' => $p['price'], 'image' => $p['image'], 'description' => $p['category_name']];
                        include BASE_PATH . '/components/product-card.php';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/cart.js"></script>
</body>
</html>
