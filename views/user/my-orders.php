<?php
require_once __DIR__ . '/../../controllers/OrderController.php';

$orderController = new OrderController();
$orders = $orderController->getUserOrders();

function getStatusBadgeClass($status) {
    switch (strtolower($status)) {
        case 'processing': return 'text-bg-warning';
        case 'out for delivery': return 'text-bg-info';
        case 'done': return 'text-bg-success';
        case 'canceled': return 'text-bg-danger';
        default: return 'text-bg-secondary';
    }
}
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
    <!-- Back to Home -->
    <div class="mb-4">
        <a href="home.php" class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-1"></i> Back to Menu
        </a>
    </div>

    <div class="dashboard-header mb-4">
        <h2 class="section-title mb-1">My Orders</h2>
        <p class="text-muted mb-0">Track and manage your recent cafeteria transactions</p>
    </div>

    <!-- Orders Table Section -->
    <div class="card overflow-hidden shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="px-4 py-3">Order Date</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-end">Total Price</th>
                        <th class="px-4 py-3 text-center">View Details</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    <?php if (empty($orders)): ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-bag-x fs-1 d-block mb-3"></i>
                                You haven't placed any orders yet.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($orders as $index => $order): ?>
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="fw-bold"><?php echo date('M d, Y', strtotime($order['order_date'])); ?></div>
                                    <div class="text-muted small"><?php echo date('h:i A', strtotime($order['order_date'])); ?></div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="badge <?php echo getStatusBadgeClass($order['status']); ?> status-badge px-3 py-2">
                                        <?php echo ucwords($order['status']); ?>
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-end fw-bold fs-5 text-dark">$<?php echo number_format($order['total_price'], 2); ?></td>
                                <td class="px-4 py-3 text-center">
                                    <button class="btn btn-light rounded-pill shadow-sm px-3" type="button" data-bs-toggle="collapse" data-bs-target="#orderDetails<?php echo $order['id']; ?>">
                                        <i class="bi bi-eye me-1"></i> Details
                                    </button>
                                </td>
                            </tr>
                            <tr class="collapse" id="orderDetails<?php echo $order['id']; ?>">
                                <td colspan="4" class="p-0 border-0">
                                    <div class="bg-light p-4">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h6 class="text-uppercase small fw-bold text-muted mb-3">Order Items</h6>
                                                <div class="d-grid gap-2">
                                                    <?php foreach ($order['items'] as $item): ?>
                                                        <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded-3 shadow-sm border-start border-warning border-4">
                                                            <div class="d-flex align-items-center gap-3">
                                                                <div>
                                                                    <div class="fw-bold"><?php echo $item['product_name']; ?></div>
                                                                    <div class="text-muted small">Qty: <?php echo $item['quantity']; ?> × $<?php echo number_format($item['price'], 2); ?></div>
                                                                </div>
                                                            </div>
                                                            <div class="fw-bold text-primary">$<?php echo number_format($item['quantity'] * $item['price'], 2); ?></div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-4 mt-md-0">
                                                <div class="card h-100 bg-white shadow-sm">
                                                    <div class="card-body">
                                                        <h6 class="fw-bold mb-3 border-bottom pb-2">Delivery Info</h6>
                                                        <div class="mb-2">
                                                            <span class="text-muted small">Room:</span>
                                                            <span class="fw-bold d-block">Room <?php echo $order['room_no']; ?></span>
                                                        </div>
                                                        <?php if (!empty($order['notes'])): ?>
                                                        <div>
                                                            <span class="text-muted small">Notes:</span>
                                                            <p class="mb-0 small fst-italic"><?php echo htmlspecialchars($order['notes']); ?></p>
                                                        </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
