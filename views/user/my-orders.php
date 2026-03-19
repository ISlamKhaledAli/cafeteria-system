<?php
 
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/navbar.php';
?>

<div class="container-fluid py-5 px-4" style="background-color: #fcfcfc; min-height: 100vh;">
    <div class="mb-5 text-start">
        <h1 class="fw-bold text-dark mb-1">Your Order History</h1>
        <p class="text-muted small">Review all your previous cafeteria orders at a glance.</p>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-start">
                <thead style="background-color: #fafafa;">
                    <tr class="text-muted" style="font-size: 0.75rem; letter-spacing: 0.8px; text-transform: uppercase;">
                        <th class="ps-4 fw-bold border-bottom py-3 text-start">Date & ID</th>
                        <th class="fw-bold border-bottom py-3 text-start">Status</th>
                        <th class="fw-bold border-bottom py-3 text-start">Delivery Spot</th>
                        <th class="fw-bold border-bottom py-3 text-start">Total Paid</th>
                        <th class="text-end pe-4 fw-bold border-bottom py-3">Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($orders)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-clock-history fs-1 d-block mb-3 opacity-25"></i>
                                <p class="mb-0">You haven't placed any orders yet. <a href="index.php?page=home" class="text-warning fw-bold text-decoration-none">Order Something!</a></p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($orders as $order): ?>
                            <?php 
                                $s = $order['status'] ?? 'processing';
                                $cfg = [
                                    'processing'       => ['bg'=>'#FEF3C7','color'=>'#B45309'],
                                    'out_for_delivery' => ['bg'=>'#E0F2FE','color'=>'#0369A1'],
                                    'delivered'        => ['bg'=>'#D1FAE5','color'=>'#047857'],
                                    'canceled'         => ['bg'=>'#FEE2E2','color'=>'#B91C1C'],
                                ][$s] ?? ['bg'=>'#f3f4f6','color'=>'#374151'];
                            ?>
                            <tr class="expandable-row border-bottom" onclick="toggleOrderDetails('order-<?= $order['id'] ?>')" style="cursor: pointer;">
                                <td class="ps-4 py-3">
                                    <div class="fw-bold text-dark" style="font-size: 0.95rem;"><?= date('M d, Y', strtotime($order['created_at'])) ?></div>
                                    <div class="text-muted" style="font-size: 0.8rem;">REF: #ORD-<?= sprintf('%05d', $order['id']) ?></div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill px-3 py-1 fw-bold text-uppercase" 
                                          style="font-size: 0.65rem; background-color: <?= $cfg['bg'] ?>; color: <?= $cfg['color'] ?>;">
                                        <?= str_replace('_', ' ', htmlspecialchars($s)) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge text-secondary border px-3 py-2 rounded-pill shadow-xs" style="background-color: #f3f4f6; font-weight: 500; font-size: 0.85rem;">
                                        Room: <?= htmlspecialchars($order['room_no']) ?>
                                    </span>
                                </td>
                                <td class="fw-bold text-dark fs-6"><?= number_format($order['total_price'], 2) ?> <small class="text-muted">EGP</small></td>
                                <td class="pe-4 text-end">
                                    <button class="btn btn-light rounded-circle shadow-sm p-2 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        <i class="bi bi-chevron-down text-warning"></i>
                                    </button>
                                </td>
                            </tr>
                            
                             <tr id="order-<?= $order['id'] ?>" class="order-details-pane" style="display: none; background-color: #fcfcfc;">
                                <td colspan="5" class="p-4 p-md-5">
                                    <div class="row g-4">
                                        <div class="col-md-7">
                                            <h6 class="fw-bold text-uppercase small text-muted mb-3" style="letter-spacing: 0.5px;">Order Items Breakdown</h6>
                                            <div class="bg-white rounded-4 shadow-sm p-4">
                                                <?php foreach ($order['items'] as $item): ?>
                                                    <div class="d-flex justify-content-between align-items-center py-2 mb-2">
                                                        <div class="d-flex align-items-center gap-3 text-start">
                                                            <?php $itemImg = !empty($item['image']) ? $item['image'] : 'default.png'; ?>
                                                            <img src="/cafeteria-system-develop/uploads/products/<?= $itemImg ?>" 
                                                                 class="rounded-3 shadow-sm border border-white" style="width: 48px; height: 48px; object-fit: cover;"
                                                                 onerror="this.src='https://placehold.co/80x80?text=Food'">
                                                            <div>
                                                                <div class="fw-bold text-dark" style="font-size: 0.95rem;"><?= htmlspecialchars($item['name']) ?></div>
                                                                <div class="text-muted" style="font-size: 0.72rem;"><?= $item['quantity'] ?> units at <?= number_format($item['price'], 2) ?> EGP each</div>
                                                            </div>
                                                        </div>
                                                        <div class="fw-bold text-dark"><?= number_format($item['price'] * $item['quantity'], 2) ?> EGP</div>
                                                    </div>
                                                <?php endforeach; ?>
                                                <div class="border-top mt-3 pt-3 d-flex justify-content-between">
                                                    <span class="fw-bold text-muted">Total Paid</span>
                                                    <span class="fw-bold text-dark fs-5"><?= number_format($order['total_price'], 2) ?> EGP</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <h6 class="fw-bold text-uppercase small text-muted mb-3" style="letter-spacing: 0.5px;">Personal Notes & Info</h6>
                                            <div class="bg-white rounded-4 shadow-sm p-4 h-100 text-start">
                                                <div class="mb-4 d-flex align-items-start gap-2">
                                                    <i class="bi bi-chat-dots-fill text-warning mt-1"></i>
                                                    <div>
                                                        <div class="text-muted small fw-bold text-uppercase" style="font-size: 0.65rem;">Special Instructions</div>
                                                        <p class="text-dark mb-0 font-italic small lh-sm mt-1">
                                                            <?= !empty($order['notes']) ? '"' . htmlspecialchars($order['notes']) . '"' : 'No specific requests provided with this order.' ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="bi bi-calendar-check-fill text-muted"></i>
                                                    <span class="text-muted small">Placed on <?= date('d M Y, H:i', strtotime($order['created_at'])) ?></span>
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

<style>
    .expandable-row:hover { background-color: #f8f9fa !important; }
    .order-details-pane { transition: all 0.3s ease; }
    .extra-small { font-size: 0.65rem; }
    .transition-all { transition: all 0.2s ease; }
</style>

<script>
function toggleOrderDetails(id) {
    const pane = document.getElementById(id);
    const isCurrentlyVisible = (pane.style.display === 'table-row');
    
    // Close other open detail panes (optional, for cleaner feel)
    document.querySelectorAll('.order-details-pane').forEach(el => el.style.display = 'none');
    document.querySelectorAll('.bi-chevron-up').forEach(icon => {
        icon.classList.replace('bi-chevron-up', 'bi-chevron-down');
    });

    if (!isCurrentlyVisible) {
        pane.style.display = 'table-row';
        const icon = pane.previousElementSibling.querySelector('.bi-chevron-down');
        if(icon) icon.classList.replace('bi-chevron-down', 'bi-chevron-up');
    }
}
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
