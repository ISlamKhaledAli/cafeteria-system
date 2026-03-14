<?php
// Dummy Data
$products = [
    ['name' => 'Tea', 'price' => 5, 'image' => 'https://images.unsplash.com/photo-1594631252845-29fc4586d5d7?q=80&w=400&auto=format&fit=crop'],
    ['name' => 'Coffee', 'price' => 6, 'image' => 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?q=80&w=400&auto=format&fit=crop'],
    ['name' => 'Green Tea', 'price' => 4, 'image' => 'https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?q=80&w=400&auto=format&fit=crop'],
    ['name' => 'Cola', 'price' => 3, 'image' => 'https://images.unsplash.com/photo-1622483767028-3f66f32aef97?q=80&w=400&auto=format&fit=crop'],
    ['name' => 'Nescafe', 'price' => 8, 'image' => 'https://images.unsplash.com/photo-1544787210-22c66bc17943?q=80&w=400&auto=format&fit=crop'],
    ['name' => 'Chocolate', 'price' => 7, 'image' => 'https://images.unsplash.com/photo-1548907040-4baa42d10919?q=80&w=400&auto=format&fit=crop'],
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
    </style>
</head>
<body>

<div class="container py-5">
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
                $name = $product['name'];
                $price = $product['price'];
                $image = $product['image'];
                include 'c:/Users/khale/OneDrive/Desktop/cafeteria-system/components/product-card.php'; 
            ?>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
