<?php
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/navbar.php';
?>

<div class="container-fluid py-4 px-4" style="background-color: #fcfcfc; min-height: 100vh;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 fw-bold mb-1 text-dark"><i class="bi bi-box-seam text-warning me-2"></i>Orders Management</h2>
            <p class="text-muted small mb-0">Track, update, and manage all cafeteria orders.</p>
        </div>
        <div class="position-relative d-none d-md-block">
            <i class="fas fa-search position-absolute text-muted" style="top: 50%; left: 15px; transform: translateY(-50%);"></i>
            <input type="text" id="orderSearch" class="form-control ps-5 bg-white border" placeholder="Search orders..." 
                   style="border-radius: 8px; border-color: #eaeaea !important; box-shadow: 0 1px 3px rgba(0,0,0,0.02); width: 250px;">
        </div>
    </div>

    <style>
        .badge-processing { background: #FEF3C7; color: #B45309; border: 1px solid #FDE68A; }
        .badge-out_for_delivery { background: #E0F2FE; color: #0369A1; border: 1px solid #BAE6FD; }
        .badge-delivered { background: #D1FAE5; color: #047857; border: 1px solid #A7F3D0; }
        .badge-canceled { background: #FEE2E2; color: #B91C1C; border: 1px solid #FECACA; }
        
        .expandable-row { cursor: pointer; transition: background-color 0.2s ease; }
        .expandable-row:hover { background-color: #f8f9fa !important; }
        .item-row { border-bottom: 1px dashed #e2e8f0; padding: 0.75rem 0; }
        .item-row:last-child { border-bottom: none; }
        
        .chevron-icon { transition: transform 0.3s ease; }
        .row-expanded .chevron-icon { transform: rotate(180deg); }
    </style>

    <div class="card border border-light shadow-sm" style="border-radius: 12px; overflow: hidden; border-color: #f0f0f0 !important;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0 text-start">
                    <thead style="background-color: #fafafa;">
                        <tr class="text-muted" style="font-size: 0.75rem; letter-spacing: 0.8px; text-transform: uppercase;">
                            <th class="ps-4 fw-bold border-bottom py-3">Order Ref</th>
                            <th class="fw-bold border-bottom py-3">Customer</th>
                            <th class="fw-bold border-bottom py-3">Location</th>
                            <th class="fw-bold border-bottom py-3">Amount</th>
                            <th class="fw-bold border-bottom py-3">Status</th>
                            <th class="text-end pe-4 fw-bold border-bottom py-3">View</th>
                        </tr>
                    </thead>
                    <tbody id="ordersTableBody">
                        <?php if (empty($orders)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                            <i class="bi bi-inbox fs-1 text-muted opacity-50"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark">No Orders Yet</h5>
                                        <p class="mb-0">When users place orders, they will appear here.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($orders as $order): ?>
                                <tr class="expandable-row border-bottom" data-bs-toggle="collapse" data-bs-target="#order-<?= (int)$order['id'] ?>" aria-expanded="false">
                                    <td class="ps-4 py-3">
                                        <div class="fw-bold text-dark" style="font-size: 0.95rem;">#ORD-<?= sprintf('%05d', $order['id']) ?></div>
                                        <div class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-clock me-1"></i><?= date('M d, Y h:i A', strtotime($order['created_at'])) ?></div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark" style="font-size: 0.9rem;"><?= htmlspecialchars($order['user_name'] ?? 'Unknown User') ?></div>
                                        <div class="text-muted" style="font-size: 0.75rem;"><?= htmlspecialchars($order['user_email'] ?? '') ?></div>
                                    </td>
                                    <td>
                                        <span class="badge text-dark border px-3 py-2 rounded-pill shadow-sm" style="background-color: #ffffff; font-weight: 600; font-size: 0.8rem;">
                                            <i class="bi bi-geo-alt-fill text-warning me-1"></i> <?= htmlspecialchars($order['room_no'] ?? '') ?>
                                        </span>
                                    </td>
                                    <td class="fw-bold text-dark fs-6">
                                        <?= number_format((float)($order['total_price'] ?? 0), 2) ?> <small class="text-muted" style="font-size: 0.7rem;">EGP</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?= strtolower($order['status'] ?? '') ?> rounded-pill px-3 py-2 fw-bold text-uppercase shadow-sm" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                                            <?= str_replace('_', ' ', htmlspecialchars($order['status'] ?? '')) ?>
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-light rounded-circle shadow-sm d-inline-flex align-items-center justify-content-center border" style="width: 32px; height: 32px;">
                                            <i class="bi bi-chevron-down text-warning chevron-icon"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="6" class="p-0 border-0">
                                        <div class="collapse" id="order-<?= (int)$order['id'] ?>">
                                            <div class="p-4 px-md-5" style="background-color: #FAFAFA; border-bottom: 2px solid #eaeaea;">
                                                <div class="row g-4">
                                                    
                                                    <div class="col-md-7">
                                                        <div class="d-flex align-items-center mb-3">
                                                            <i class="bi bi-bag-check-fill text-warning me-2 fs-5"></i>
                                                            <h6 class="fw-bold text-uppercase small text-muted mb-0" style="letter-spacing: 0.8px;">Order Summary</h6>
                                                        </div>
                                                        <div class="bg-white rounded-4 shadow-sm p-4 border border-light">
                                                            <?php if (!empty($order['items'])): ?>
                                                                <?php foreach ($order['items'] as $item): ?>
                                                                    <div class="item-row d-flex justify-content-between align-items-center">
                                                                        <div class="d-flex align-items-center gap-3">
                                                                        
                                                                            <?php 
                                                                                $itemImg = !empty($item['image']) ? $item['image'] : 'default.png';
                                                                                $imgSrc = (strpos($itemImg, 'http') === 0) ? $itemImg : 'uploads/products/' . $itemImg;
                                                                            ?>
                                                                            <img src="<?= $imgSrc ?>"
                                                                                class="rounded-3 shadow-sm border"
                                                                                style="width: 48px; height: 48px; object-fit: cover;"
                                                                                onerror="this.src='https://placehold.co/80x80?text=Food'">
                                                                            <div>
                                                                                <div class="fw-bold text-dark" style="font-size: 0.9rem;"><?= htmlspecialchars($item['name'] ?? '') ?></div>
                                                                                <div class="text-muted" style="font-size: 0.75rem;">Qty: <?= (int)$item['quantity'] ?> × <?= number_format((float)$item['price'], 2) ?> EGP</div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="fw-bold text-dark fs-6">
                                                                            <?= number_format((float)($item['price'] * $item['quantity']), 2) ?> EGP
                                                                        </div>
                                                                    </div>
                                                                <?php endforeach; ?>
                                                                
                                                                <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                                                                    <span class="fw-bold text-muted text-uppercase small">Grand Total</span>
                                                                    <span class="fw-bold text-warning fs-5"><?= number_format((float)$order['total_price'], 2) ?> EGP</span>
                                                                </div>
                                                            <?php else: ?>
                                                                <div class="text-muted text-center small">No items found for this order.</div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <div class="d-flex align-items-center mb-3">
                                                            <i class="bi bi-sliders text-warning me-2 fs-5"></i>
                                                            <h6 class="fw-bold text-uppercase small text-muted mb-0" style="letter-spacing: 0.8px;">Action & Info</h6>
                                                        </div>
                                                        <div class="bg-white rounded-4 shadow-sm p-4 border border-light h-100 d-flex flex-column">
                                                            
                                                            <div class="mb-4 bg-light p-3 rounded-3 border border-warning border-opacity-25">
                                                                <div class="text-muted small fw-bold text-uppercase mb-1" style="font-size: 0.65rem;">User Notes</div>
                                                                <p class="mb-0 text-dark small font-italic fw-medium">
                                                                    <?= !empty($order['notes']) ? '"' . htmlspecialchars($order['notes']) . '"' : 'No specific instructions provided.' ?>
                                                                </p>
                                                            </div>

                                                            <div class="mt-auto">
                                                                <form method="POST" action="index.php?page=admin-update-order-status" onsubmit="confirmStatusUpdate(event, this)">
                                                                    <input type="hidden" name="order_id" value="<?= (int)$order['id'] ?>">
                                                                    <label class="form-label fw-bold small text-muted text-uppercase" style="font-size: 0.7rem;">Update Order Status</label>
                                                                    <div class="input-group shadow-sm" style="border-radius: 10px; overflow: hidden;">
                                                                        <select name="status" class="form-select bg-light border-0 py-2 fw-semibold text-dark">
                                                                            <?php
                                                                            $current = $order['status'] ?? 'processing';
                                                                            $options = ['processing', 'out_for_delivery', 'delivered', 'canceled'];
                                                                            foreach ($options as $opt):
                                                                                $selected = ($opt === $current) ? 'selected' : '';
                                                                            ?>
                                                                                <option value="<?= $opt ?>" <?= $selected ?>><?= ucwords(str_replace('_', ' ', $opt)) ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <button class="btn text-white fw-bold px-4 transition-all" type="submit" style="background-color:#d97706;">
                                                                            Update
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            
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
</div>

<script>
// تدوير السهم (Chevron) عند فتح وغلق تفاصيل الطلب
document.addEventListener('DOMContentLoaded', function() {
    const collapsibles = document.querySelectorAll('.collapse');
    collapsibles.forEach(collapseEl => {
        collapseEl.addEventListener('show.bs.collapse', function () {
            const triggerRow = document.querySelector(`[data-bs-target="#${this.id}"]`);
            if(triggerRow) triggerRow.classList.add('row-expanded');
        });
        collapseEl.addEventListener('hide.bs.collapse', function () {
            const triggerRow = document.querySelector(`[data-bs-target="#${this.id}"]`);
            if(triggerRow) triggerRow.classList.remove('row-expanded');
        });
    });
});

// الفلترة اللحظية
document.getElementById('orderSearch')?.addEventListener('input', function() {
    const q = this.value.toLowerCase();
    const rows = document.querySelectorAll('.expandable-row');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        // إخفاء الصف والـ Collapse بتاعه لو مش مطابق للبحث
        const targetId = row.getAttribute('data-bs-target');
        const detailsRow = document.querySelector(targetId)?.parentElement.parentElement;
        
        if(text.includes(q)) {
            row.style.display = '';
            if(detailsRow) detailsRow.style.display = '';
        } else {
            row.style.display = 'none';
            if(detailsRow) detailsRow.style.display = 'none';
        }
    });
});

// تأكيد تغيير الحالة باستخدام SweetAlert2 مع أنيميشن التحميل
function confirmStatusUpdate(event, formElement) {
    event.preventDefault();
    const select = formElement.querySelector('select[name="status"]');
    const newStatus = select.options[select.selectedIndex].text;

    Swal.fire({
        title: 'Update Status?',
        html: `Are you sure you want to change this order status to <br><b class="text-warning">${newStatus}</b>?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#d97706',
        cancelButtonColor: '#9ca3af',
        confirmButtonText: 'Yes, Update!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Updating...',
                text: 'Please wait while the order is being updated.',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            formElement.submit();
        }
    });
}
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>