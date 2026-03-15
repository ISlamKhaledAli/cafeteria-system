<?php
// Dummy Data
$products = [
    ['id' => 1, 'name' => 'Tea', 'price' => 5, 'image' => 'https://images.unsplash.com/photo-1594631252845-29fc4586d5d7?q=80&w=400&auto=format&fit=crop'],
    ['id' => 2, 'name' => 'Coffee', 'price' => 6, 'image' => 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?q=80&w=400&auto=format&fit=crop'],
    ['id' => 3, 'name' => 'Green Tea', 'price' => 4, 'image' => 'https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?q=80&w=400&auto=format&fit=crop'],
    ['id' => 4, 'name' => 'Cola', 'price' => 3, 'image' => 'https://images.unsplash.com/photo-1622483767028-3f66f32aef97?q=80&w=400&auto=format&fit=crop'],
    ['id' => 5, 'name' => 'Nescafe', 'price' => 8, 'image' => 'https://images.unsplash.com/photo-1544787210-22c66bc17943?q=80&w=400&auto=format&fit=crop'],
    ['id' => 6, 'name' => 'Chocolate', 'price' => 7, 'image' => 'https://images.unsplash.com/photo-1548907040-4baa42d10919?q=80&w=400&auto=format&fit=crop'],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Cafeteria System</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-orange: #F59E0B;
            --bg-light-gray: #F3F4F6;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light-gray);
            color: #1F2937;
        }

        .dashboard-header {
            margin-bottom: 2rem;
        }

        .section-title {
            font-weight: 700;
            color: #111827;
            border-left: 5px solid var(--primary-orange);
            padding-left: 1rem;
        }

        .search-container .form-control {
            border-radius: 50px;
            padding-left: 2.5rem;
            border: 1px solid #E5E7EB;
        }

        .search-container .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
        }

        /* Cart Sidebar Styles */
        #cart-sidebar {
            position: fixed;
            right: -400px;
            top: 0;
            width: 400px;
            height: 100vh;
            background: white;
            box-shadow: -5px 0 15px rgba(0,0,0,0.1);
            z-index: 1050;
            transition: right 0.3s ease;
            display: flex;
            flex-column: column;
        }

        #cart-sidebar.active {
            right: 0;
        }

        .cart-header {
            padding: 1.5rem;
            border-bottom: 1px solid #E5E7EB;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #cart-items {
            flex-grow: 1;
            overflow-y: auto;
            padding: 1.5rem;
        }

        .cart-footer {
            padding: 1.5rem;
            border-top: 1px solid #E5E7EB;
            background: #F9FAFB;
        }

        .cart-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #F3F4F6;
        }

        .cart-item-info {
            flex-grow: 1;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: #F3F4F6;
            border-radius: 50px;
            padding: 2px 8px;
        }

        .cart-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0,0,0,0.5);
            z-index: 1040;
            display: none;
        }

        .cart-overlay.show {
            display: block;
        }

        #cart-count-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            font-size: 0.7rem;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <!-- Floating Cart Toggle -->
    <button class="btn btn-primary rounded-circle shadow-lg position-fixed bottom-0 end-0 m-4 p-3 d-flex align-items-center justify-content-center" 
            id="cart-toggle" 
            style="width: 60px; height: 60px; background-color: var(--primary-orange); border: none; z-index: 1000;">
        <i class="bi bi-cart3 fs-4"></i>
        <span class="badge rounded-pill bg-danger" id="cart-count-badge">0</span>
    </button>

    <!-- Cart Sidebar -->
    <div class="cart-overlay" id="cart-overlay"></div>
    <div id="cart-sidebar" class="flex-column">
        <div class="cart-header">
            <h4 class="fw-bold mb-0">Your Cart</h4>
            <button type="button" class="btn-close" id="close-cart"></button>
        </div>
        <div id="cart-items">
            <!-- Items will be injected here -->
            <div class="text-center text-muted py-5">
                <i class="bi bi-cart fs-1 d-block mb-3"></i>
                Your cart is empty
            </div>
        </div>
        <div class="cart-footer">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="fw-bold fs-5">Total</span>
                <span class="fw-bold fs-4 text-primary" id="cart-total">$0.00</span>
            </div>
            <a href="cart.php" class="btn btn-primary w-100 py-3 rounded-pill fw-bold text-decoration-none d-flex align-items-center justify-content-center" style="background-color: var(--primary-orange); border: none;">
                Checkout
            </a>
        </div>
    </div>

    <!-- Dashbord Header -->
    <div class="dashboard-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h2 class="section-title mb-1">Menu</h2>
            <p class="text-muted mb-0">Discover our delicious beverages and snacks</p>
        </div>
        <div class="search-container position-relative" style="min-width: 300px;">
            <i class="bi bi-search search-icon"></i>
            <input type="text" class="form-control" placeholder="Search for items...">
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($products as $product): ?>
            <?php 
                $id = $product['id'];
                $name = $product['name'];
                $price = $product['price'];
                $image = $product['image'];
                include_once __DIR__ . '/../../config/constants.php';
                include BASE_PATH . '/components/product-card.php'; 
            ?>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/cart.js"></script>
</body>
</html>
