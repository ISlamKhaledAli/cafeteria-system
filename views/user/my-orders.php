<?php
include_once __DIR__ . '/../../config/constants.php';

// Dummy Order Data
$orders = [
    [
        'id' => 'ORD-94821',
        'date' => 'Oct 24, 2023',
        'status' => 'Processing',
        'status_class' => 'text-bg-warning',
        'total' => 24.50,
        'items' => [
            ['name' => 'Classic Cheese Burger', 'qty' => 2, 'price' => 8.50],
            ['name' => 'Large Iced Latte', 'qty' => 1, 'price' => 4.50],
            ['name' => 'Chocolate Chip Cookie', 'qty' => 3, 'price' => 1.00],
        ]
    ],
    [
        'id' => 'ORD-93712',
        'date' => 'Oct 22, 2023',
        'status' => 'Delivered',
        'status_class' => 'text-bg-info',
        'total' => 12.80,
    ],
    [
        'id' => 'ORD-92104',
        'date' => 'Oct 20, 2023',
        'status' => 'Done',
        'status_class' => 'text-bg-success',
        'total' => 35.00,
    ],
    [
        'id' => 'ORD-91552',
        'date' => 'Oct 18, 2023',
        'status' => 'Done',
        'status_class' => 'text-bg-success',
        'total' => 9.25,
    ],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - Cafeteria System</title>
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

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .btn-primary {
            background-color: var(--primary-orange);
            border-color: var(--primary-orange);
        }

        .btn-primary:hover {
            background-color: #D97706;
            border-color: #D97706;
        }

        .table thead th {
            background-color: rgba(245, 158, 11, 0.05);
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            color: #6B7280;
            border-bottom: 2px solid rgba(245, 158, 11, 0.1);
        }

        .status-badge {
            font-weight: 700;
            padding: 0.5rem 1rem;
            border-radius: 50px;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <!-- Dashboard Header -->
    <div class="dashboard-header mb-4">
        <h2 class="section-title mb-1">My Orders</h2>
        <p class="text-muted mb-0">Track and manage your recent cafeteria transactions</p>
    </div>

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-calendar3 me-2 text-warning"></i> Filter by Date</h5>
            <form class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-muted">From</label>
                    <input type="date" class="form-control" value="2023-10-01">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-muted">To</label>
                    <input type="date" class="form-control" value="2023-10-31">
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-primary w-100 fw-bold">Apply Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Orders Table Section -->
    <div class="card overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-end">Total Price</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    <?php foreach ($orders as $index => $order): ?>
                        <tr>
                            <td class="px-4 py-3">
                                <div class="fw-bold"><?php echo $order['date']; ?></div>
                                <div class="text-muted small"><?php echo $order['id']; ?></div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="badge <?php echo $order['status_class']; ?> status-badge px-3 py-2">
                                    <?php echo $order['status']; ?>
                                </span>
                            </td>
                            <td class="px-4 py-3 text-end fw-bold fs-5 text-dark">$<?php echo number_format($order['total'], 2); ?></td>
                            <td class="px-4 py-3 text-center">
                                <button class="btn btn-light rounded-circle shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#orderDetails<?php echo $index; ?>">
                                    <i class="bi bi-chevron-down"></i>
                                </button>
                            </td>
                        </tr>
                        <?php if (isset($order['items'])): ?>
                        <tr class="collapse" id="orderDetails<?php echo $index; ?>">
                            <td colspan="4" class="p-0 border-0">
                                <div class="bg-light p-4 shadow-inner">
                                    <h6 class="text-uppercase small fw-bold text-muted tracking-wider mb-3">Order Items</h6>
                                    <div class="d-grid gap-2">
                                        <?php foreach ($order['items'] as $item): ?>
                                            <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded-3 shadow-sm">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="bg-warning bg-opacity-10 p-2 rounded text-warning">
                                                        <i class="bi bi-bag-check-fill fs-5"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold small"><?php echo $item['name']; ?></div>
                                                        <div class="text-muted extra-small">Qty: <?php echo $item['qty']; ?> × $<?php echo number_format($item['price'], 2); ?></div>
                                                    </div>
                                                </div>
                                                <div class="fw-bold">$<?php echo number_format($item['qty'] * $item['price'], 2); ?></div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mt-4 px-2">
        <p class="text-muted small mb-0">Showing 4 of 24 orders</p>
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm mb-0">
                <li class="page-item disabled">
                    <a class="page-link shadow-sm border-0 rounded mx-1" href="#"><i class="bi bi-chevron-left"></i></a>
                </li>
                <li class="page-item active"><a class="page-link shadow-sm border-0 rounded mx-1 px-3" href="#" style="background-color: var(--primary-orange);">1</a></li>
                <li class="page-item"><a class="page-link shadow-sm border-0 rounded mx-1 px-3 text-dark" href="#">2</a></li>
                <li class="page-item"><a class="page-link shadow-sm border-0 rounded mx-1 px-3 text-dark" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link shadow-sm border-0 rounded mx-1" href="#"><i class="bi bi-chevron-right"></i></a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
