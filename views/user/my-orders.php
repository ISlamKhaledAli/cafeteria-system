<?php
/**
 * My Orders Page - Order History
 * FIXED: Schema alignment (created_at instead of order_date).
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History - Cafeteria</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root { --primary-orange: #F59E0B; --bg-gray: #F8F7F6; }
        body { background-color: var(--bg-gray); font-family: 'Inter', sans-serif; }
        .table-card { border: none; border-radius: 24px; overflow: hidden; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); }
        .badge-processing { background: #FEF3C7; color: #B45309; }
        .badge-out_for_delivery { background: #E0F2FE; color: #0369A1; }
        .badge-delivered { background: #D1FAE5; color: #047857; }
        .badge-canceled { background: #FEE2E2; color: #B91C1C; }
        .table th { font-weight: 700; color: #6B7280; text-transform: uppercase; font-size: 0.75rem; border: none; padding: 1.25rem 1rem; }
        .expandable-row { cursor: pointer; transition: background 0.2s; }
        .expandable-row:hover { background-color: #F9FAFB !important; }
        .order-details { display: none; background-color: #FAFAFA; }
        .item-row { border-bottom: 1px dotted #E5E7EB; padding: 0.75rem 0; }
        .item-row:last-child { border-bottom: none; }
    </style>
</head>
<body>
    <?php include BASE_PATH . '/layouts/navbar.php'; ?>

    <div class="container py-5 mt-4">
        <h1 class="fw-bold mb-2">Order History</h1>
        <p class="text-secondary mb-5">Review and track your recent cafeteria orders</p>

        <div class="card table-card bg-white">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Date & ID</th>
                            <th>Status</th>
                            <th class="text-center">Total Amount</th>
                            <th class="pe-4 text-end">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($orders)): ?>
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="bi bi-clock-history fs-1 d-block mb-3 opacity-25"></i>
                                    You haven't placed any orders yet.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($orders as $order): ?>
                                <tr class="expandable-row border-bottom" onclick="toggleDetails('order-<?= $order['id'] ?>')">
                                    <td class="ps-4">
                                        <!-- FIXED: created_at used instead of order_date -->
                                        <div class="fw-bold text-dark"><?= date('F d, Y', strtotime($order['created_at'])) ?></div>
                                        <div class="text-muted small">Reference: #ORD-<?= sprintf('%05d', $order['id']) ?></div>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?= strtolower($order['status']) ?> rounded-pill px-3 py-2 fw-bold text-uppercase" style="font-size: 0.65rem;">
                                            <?= str_replace('_', ' ', htmlspecialchars($order['status'])) ?>
                                        </span>
                                    </td>
                                    <td class="fw-bold text-center text-dark">$<?= number_format($order['total_price'], 2) ?></td>
                                    <td class="pe-4 text-end">
                                        <button class="btn btn-light rounded-circle p-2 mx-1"><i class="bi bi-chevron-down text-warning"></i></button>
                                    </td>
                                </tr>
                                <tr id="order-<?= $order['id'] ?>" class="order-details border-bottom">
                                    <td colspan="4" class="p-4 px-5 bg-light-subtle">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <h6 class="fw-bold text-uppercase small text-muted mb-3 ls-1">Delivery Info</h6>
                                                <p class="mb-1 fw-bold text-dark"><i class="bi bi-geo-alt me-2 text-warning"></i> Room: <?= htmlspecialchars($order['room_no']) ?></p>
                                                <p class="mb-3 text-muted small px-4 font-italic"><?= $order['notes'] ? '"' . htmlspecialchars($order['notes']) . '"' : 'No instructions provided.' ?></p>
                                                
                                                <h6 class="fw-bold text-uppercase small text-muted mb-3 ls-1">Order Items</h6>
                                                <?php foreach ($order['items'] as $item): ?>
                                                    <div class="item-row d-flex justify-content-between align-items-center mb-1">
                                                        <div class="d-flex align-items-center gap-3">
                                                            <img src="uploads/products/<?= $item['image'] ?: 'default-product.png' ?>" 
                                                                 class="rounded shadow-sm" 
                                                                 style="width: 40px; height: 40px; object-fit: cover;"
                                                                 onerror="this.src='https://placehold.co/80x80?text=<?= urlencode($item['name']) ?>'">
                                                            <div>
                                                                <div class="fw-bold small"><?= htmlspecialchars($item['name']) ?></div>
                                                                <div class="text-muted" style="font-size: 0.7rem;">Qty: <?= $item['quantity'] ?> × $<?= number_format($item['price'], 2) ?></div>
                                                            </div>
                                                        </div>
                                                        <div class="fw-bold text-dark small">$<?= number_format($item['price'] * $item['quantity'], 2) ?></div>
                                                    </div>
                                                <?php endforeach; ?>
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

    <script>
        function toggleDetails(id) {
            const el = document.getElementById(id);
            if (!el) return;
            const currentRow = el.previousElementSibling;
            const icon = currentRow.querySelector('.bi-chevron-down, .bi-chevron-up');
            
            if (el.style.display === 'table-row') {
                el.style.display = 'none';
                if (icon) icon.classList.replace('bi-chevron-up', 'bi-chevron-down');
                currentRow.classList.remove('bg-light');
            } else {
                document.querySelectorAll('.order-details').forEach(row => row.style.display = 'none');
                document.querySelectorAll('.bi-chevron-up').forEach(i => i.classList.replace('bi-chevron-up', 'bi-chevron-down'));
                
                el.style.display = 'table-row';
                if (icon) icon.classList.replace('bi-chevron-down', 'bi-chevron-up');
                currentRow.classList.add('bg-light');
            }
        }
    </script>
</body>
</html>
