<?php
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/navbar.php';
?>

<div class="container-fluid py-4 px-4" style="background-color: #fcfcfc; min-height: 100vh;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 fw-bold mb-0 text-dark">Orders Checks & Reports</h2>
        <div class="text-muted small fw-semibold">Filter orders by date</div>
    </div>

    <style>
        .badge-processing { background: #FEF3C7; color: #B45309; }
        .badge-out_for_delivery { background: #E0F2FE; color: #0369A1; }
        .badge-delivered { background: #D1FAE5; color: #047857; }
        .badge-canceled { background: #FEE2E2; color: #B91C1C; }
        .table th { font-weight: 700; color: #6B7280; text-transform: uppercase; font-size: 0.75rem; border: none; padding: 1.25rem 1rem; }
        .order-details { display: none; background-color: #FAFAFA; }
        .item-row { border-bottom: 1px dotted #E5E7EB; padding: 0.75rem 0; }
        .item-row:last-child { border-bottom: none; }
    </style>

    <?php
    $startValue = htmlspecialchars($_GET['start_date'] ?? '');
    $endValue = htmlspecialchars($_GET['end_date'] ?? '');
    ?>

    <div class="card border border-light shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-body">
            <form method="GET" action="index.php" class="row g-3 align-items-end">
                <input type="hidden" name="page" value="admin-checks">

                <div class="col-md-4">
                    <label class="form-label fw-semibold small text-muted">Start Date</label>
                    <input type="date" name="start_date" value="<?= $startValue ?>" class="form-control bg-white shadow-sm" style="border-radius: 10px;">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold small text-muted">End Date</label>
                    <input type="date" name="end_date" value="<?= $endValue ?>" class="form-control bg-white shadow-sm" style="border-radius: 10px;">
                </div>

                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn fw-semibold text-white shadow-sm" style="background-color:#d97706; border-radius:10px;">
                        Filter
                    </button>
                    <a href="index.php?page=admin-checks" class="btn btn-light fw-semibold shadow-sm" style="border-radius:10px;">
                        Clear
                    </a>
                </div>
            </form>

            <div class="row g-3 mt-3">
                <div class="col-md-3">
                    <div class="p-3 rounded-3 bg-light border">
                        <div class="text-muted small fw-semibold">Total Orders</div>
                        <div class="fw-bold text-dark" style="font-size: 1.25rem;"><?= (int)($stats['total'] ?? 0) ?></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3 rounded-3 bg-light border">
                        <div class="text-muted small fw-semibold">Processing</div>
                        <div class="fw-bold text-dark" style="font-size: 1.25rem;"><?= (int)($stats['processing'] ?? 0) ?></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3 rounded-3 bg-light border">
                        <div class="text-muted small fw-semibold">Out for Delivery</div>
                        <div class="fw-bold text-dark" style="font-size: 1.25rem;"><?= (int)($stats['out_for_delivery'] ?? 0) ?></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3 rounded-3 bg-light border">
                        <div class="text-muted small fw-semibold">Delivered</div>
                        <div class="fw-bold text-dark" style="font-size: 1.25rem;"><?= (int)($stats['delivered'] ?? 0) ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border border-light shadow-sm" style="border-radius: 12px; overflow: hidden; border-color: #f0f0f0 !important;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #fafafa;">
                        <tr class="text-muted" style="font-size: 0.75rem; letter-spacing: 0.8px; text-transform: uppercase;">
                            <th class="ps-4 fw-bold border-bottom py-3">Date & ID</th>
                            <th class="fw-bold border-bottom py-3">User</th>
                            <th class="fw-bold border-bottom py-3">Room</th>
                            <th class="fw-bold border-bottom py-3">Total</th>
                            <th class="fw-bold border-bottom py-3">Status</th>
                            <th class="text-end pe-4 fw-bold border-bottom py-3">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($orders)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-file-alt fs-1 mb-3 opacity-25"></i>
                                    No orders match the selected date range.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($orders as $order): ?>
                                <tr class="expandable-row border-bottom">
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">
                                            <?= date('F d, Y', strtotime($order['created_at'])) ?>
                                        </div>
                                        <div class="text-muted small">Reference: #ORD-<?= sprintf('%05d', $order['id']) ?></div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark"><?= htmlspecialchars($order['user_name'] ?? '') ?></div>
                                        <div class="text-muted small"><?= htmlspecialchars($order['user_email'] ?? '') ?></div>
                                    </td>
                                    <td>
                                        <span class="badge text-secondary border px-3 py-2 rounded-pill" style="background-color: #f3f4f6; font-weight: 500;">
                                            <?= htmlspecialchars($order['room_no'] ?? '') ?>
                                        </span>
                                    </td>
                                    <td class="fw-bold text-center text-dark"><?= number_format((float)($order['total_price'] ?? 0), 2) ?> EGP</td>
                                    <td>
                                        <span class="badge badge-<?= strtolower($order['status'] ?? '') ?> rounded-pill px-3 py-2 fw-bold text-uppercase" style="font-size: 0.65rem;">
                                            <?= str_replace('_', ' ', htmlspecialchars($order['status'] ?? '')) ?>
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <button
                                            class="btn btn-light rounded-circle p-2"
                                            onclick="toggleDetails('order-<?= (int)$order['id'] ?>')"
                                            type="button"
                                        >
                                            <i class="bi bi-chevron-down text-warning"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr id="order-<?= (int)$order['id'] ?>" class="order-details border-bottom">
                                    <td colspan="6" class="p-4 px-5 bg-light-subtle">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <h6 class="fw-bold text-uppercase small text-muted mb-3">Delivery Info</h6>
                                                <p class="mb-1 fw-bold text-dark">
                                                    <i class="bi bi-geo-alt me-2 text-warning"></i>
                                                    Room: <?= htmlspecialchars($order['room_no'] ?? '') ?>
                                                </p>
                                                <p class="mb-3 text-muted small px-4 font-italic">
                                                    <?php
                                                    $notes = $order['notes'] ?? '';
                                                    echo $notes ? '"' . htmlspecialchars($notes) . '"' : 'No instructions provided.';
                                                    ?>
                                                </p>

                                                <h6 class="fw-bold text-uppercase small text-muted mb-3">Order Items</h6>
                                                <?php if (!empty($order['items'])): ?>
                                                    <?php foreach ($order['items'] as $item): ?>
                                                        <div class="item-row d-flex justify-content-between align-items-center mb-1">
                                                            <div class="d-flex align-items-center gap-3">
                                                                <img
                                                                    src="/cafeteria-system-develop/uploads/products/<?= htmlspecialchars($item['image'] ?: '') ?>"
                                                                    class="rounded shadow-sm"
                                                                    style="width: 40px; height: 40px; object-fit: cover;"
                                                                    onerror="this.src='https://placehold.co/80x80?text=<?= urlencode($item['name'] ?? 'Product') ?>'"
                                                                >
                                                                <div>
                                                                    <div class="fw-bold small"><?= htmlspecialchars($item['name'] ?? '') ?></div>
                                                                Qty: <?= (int)($item['quantity'] ?? 0) ?> × <?= number_format((float)($item['price'] ?? 0), 2) ?> EGP
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="fw-bold text-dark small">
                                                                <?= number_format((float)(($item['price'] ?? 0) * ($item['quantity'] ?? 0)), 2) ?> EGP
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <div class="text-muted small">No items for this order.</div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-md-5">
                                                <h6 class="fw-bold text-uppercase small text-muted mb-3">Current Status</h6>
                                                <div class="p-3 rounded-3 border bg-white">
                                                    <div class="text-muted small fw-semibold">Status</div>
                                                    <div class="mt-1">
                                                        <span class="badge badge-<?= strtolower($order['status'] ?? '') ?> rounded-pill px-3 py-2 fw-bold text-uppercase" style="font-size: 0.75rem;">
                                                            <?= str_replace('_', ' ', htmlspecialchars($order['status'] ?? '')) ?>
                                                        </span>
                                                    </div>
                                                    <div class="text-muted small mt-3">
                                                        Created: <?= date('F d, Y H:i', strtotime($order['created_at'])) ?>
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
</div>

<script>
    function toggleDetails(id) {
        const el = document.getElementById(id);
        if (!el) return;

        const detailsRow = el;
        const currentRow = el.previousElementSibling;
        const icon = currentRow.querySelector('.bi-chevron-down, .bi-chevron-up');

        if (detailsRow.style.display === 'table-row') {
            detailsRow.style.display = 'none';
            if (icon) icon.classList.replace('bi-chevron-up', 'bi-chevron-down');
            currentRow.classList.remove('bg-light');
        } else {
            document.querySelectorAll('.order-details').forEach(row => row.style.display = 'none');
            document.querySelectorAll('.bi-chevron-up').forEach(i => i.classList.replace('bi-chevron-up', 'bi-chevron-down'));

            detailsRow.style.display = 'table-row';
            if (icon) icon.classList.replace('bi-chevron-down', 'bi-chevron-up');
            currentRow.classList.add('bg-light');
        }
    }
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>

