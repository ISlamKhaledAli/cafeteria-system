<?php
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/navbar.php';
?>

<div class="container-fluid py-4 px-4" style="background-color: #fcfcfc; min-height: 100vh;">

    <div class="mb-4">
        <h2 class="h4 fw-bold mb-0 text-dark">Dashboard</h2>
        <div class="text-muted small">Welcome back, <?= htmlspecialchars($_SESSION['user']['name'] ?? 'Admin') ?></div>
    </div>

     <div class="row g-3 mb-4">

        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 14px;">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center"
                         style="width:48px;height:48px;background:#FEF3C7;">
                        <i class="fas fa-users" style="color:#D97706; font-size:1.1rem;"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold" style="font-size:0.72rem; letter-spacing:0.5px; text-transform:uppercase;">Total Users</div>
                        <div class="fw-bold text-dark" style="font-size:1.5rem; line-height:1.2;"><?= $stats['total_users'] ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 14px;">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center"
                         style="width:48px;height:48px;background:#E0F2FE;">
                        <i class="fas fa-box" style="color:#0369A1; font-size:1.1rem;"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold" style="font-size:0.72rem; letter-spacing:0.5px; text-transform:uppercase;">Products</div>
                        <div class="fw-bold text-dark" style="font-size:1.5rem; line-height:1.2;"><?= $stats['total_products'] ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 14px;">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center"
                         style="width:48px;height:48px;background:#D1FAE5;">
                        <i class="fas fa-receipt" style="color:#047857; font-size:1.1rem;"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold" style="font-size:0.72rem; letter-spacing:0.5px; text-transform:uppercase;">Total Orders</div>
                        <div class="fw-bold text-dark" style="font-size:1.5rem; line-height:1.2;"><?= $stats['total_orders'] ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 14px;">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center"
                         style="width:48px;height:48px;background:#FEE2E2;">
                        <i class="fas fa-coins" style="color:#B91C1C; font-size:1.1rem;"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold" style="font-size:0.72rem; letter-spacing:0.5px; text-transform:uppercase;">Total Revenue</div>
                        <div class="fw-bold text-dark" style="font-size:1.3rem; line-height:1.2;"><?= number_format($stats['revenue_total'], 0) ?> <span style="font-size:0.85rem;">EGP</span></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

     <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 14px;">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-uppercase small text-muted mb-3" style="letter-spacing: 0.8px;">Today</h6>
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <span class="text-muted small">Orders Today</span>
                        <span class="fw-bold text-dark"><?= $stats['orders_today'] ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Revenue Today</span>
                        <span class="fw-bold text-dark"><?= number_format($stats['revenue_today'], 2) ?> EGP</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 14px;">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-uppercase small text-muted mb-3" style="letter-spacing: 0.8px;">Orders by Status</h6>
                    <?php
                    $statusConfig = [
                        'processing'       => ['label' => 'Processing',       'bg' => '#FEF3C7', 'color' => '#B45309'],
                        'out_for_delivery' => ['label' => 'Out for Delivery', 'bg' => '#E0F2FE', 'color' => '#0369A1'],
                        'delivered'        => ['label' => 'Delivered',        'bg' => '#D1FAE5', 'color' => '#047857'],
                        'canceled'         => ['label' => 'Canceled',         'bg' => '#FEE2E2', 'color' => '#B91C1C'],
                    ];
                    foreach ($statusConfig as $key => $cfg):
                        $count = $stats['by_status'][$key] ?? 0;
                    ?>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge rounded-pill px-3 py-1 fw-semibold"
                              style="background:<?= $cfg['bg'] ?>; color:<?= $cfg['color'] ?>; font-size:0.72rem;">
                            <?= $cfg['label'] ?>
                        </span>
                        <span class="fw-bold text-dark"><?= $count ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 14px;">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-uppercase small text-muted mb-3" style="letter-spacing: 0.8px;">Top Products</h6>
                    <?php if (!empty($top_products)): ?>
                        <?php foreach ($top_products as $i => $tp): ?>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-dark small"><?= htmlspecialchars($tp['name'] ?? '—') ?></span>
                            <span class="badge text-secondary border rounded-pill px-2"
                                  style="background:#f3f4f6; font-size:0.72rem;">
                                <?= (int)$tp['sold'] ?> sold
                            </span>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-muted small">No data yet.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

     <div class="card border border-light shadow-sm" style="border-radius: 12px; overflow: hidden; border-color: #f0f0f0 !important;">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center px-4 py-3 border-bottom bg-white">
                <h6 class="fw-bold text-uppercase small text-muted mb-0" style="letter-spacing: 0.8px;">Recent Orders</h6>
                <a href="index.php?page=admin-orders" class="text-decoration-none small fw-semibold"
                   style="color:#d97706;">View All →</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #fafafa;">
                        <tr class="text-muted" style="font-size: 0.75rem; letter-spacing: 0.8px; text-transform: uppercase;">
                            <th class="ps-4 fw-bold border-bottom py-3">Reference</th>
                            <th class="fw-bold border-bottom py-3">User</th>
                            <th class="fw-bold border-bottom py-3">Room</th>
                            <th class="fw-bold border-bottom py-3">Total</th>
                            <th class="fw-bold border-bottom py-3">Status</th>
                            <th class="pe-4 fw-bold border-bottom py-3">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <?php if (!empty($recent_orders)): ?>
                            <?php foreach ($recent_orders as $order): ?>
                            <?php
                                $s = $order['status'] ?? 'processing';
                                $cfg = [
                                    'processing'       => ['bg'=>'#FEF3C7','color'=>'#B45309'],
                                    'out_for_delivery' => ['bg'=>'#E0F2FE','color'=>'#0369A1'],
                                    'delivered'        => ['bg'=>'#D1FAE5','color'=>'#047857'],
                                    'canceled'         => ['bg'=>'#FEE2E2','color'=>'#B91C1C'],
                                ][$s] ?? ['bg'=>'#f3f4f6','color'=>'#374151'];
                            ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-dark">#ORD-<?= sprintf('%05d', $order['id']) ?></td>
                                    <td class="text-dark"><?= htmlspecialchars($order['user_name'] ?? '') ?></td>
                                    <td><span class="badge text-secondary border px-3 py-2 rounded-pill" style="background-color: #f3f4f6; font-weight: 500;">
                                        <?= htmlspecialchars($order['room_no'] ?? '') ?>
                                    </span></td>
                                    <td class="fw-bold text-dark"><?= number_format((float)$order['total_price'], 2) ?> EGP</td>
                                    <td>
                                        <span class="badge rounded-pill px-3 py-1 fw-semibold text-uppercase"
                                              style="background:<?= $cfg['bg'] ?>; color:<?= $cfg['color'] ?>; font-size:0.65rem;">
                                            <?= str_replace('_', ' ', htmlspecialchars($s)) ?>
                                        </span>
                                    </td>
                                    <td class="pe-4 text-muted small"><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-receipt fs-1 mb-3 opacity-25"></i>
                                    <p>No orders yet.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
