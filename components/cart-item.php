<?php
/**
 * Cart Item Component
 * FIXED: Alignment, quantity buttons, and removal action.
 * NOTE: Used primarily for design reference; dynamic items are rendered by JS.
 */
?>
<div class="cart-item d-flex align-items-center justify-content-between py-4 border-bottom bg-white rounded-4 px-3 mb-2" data-id="<?= $item['id'] ?>">
    <div class="d-flex align-items-center gap-4">
        <div class="rounded-4 bg-light shadow-sm" style="width: 70px; height: 70px; overflow: hidden;">
            <img src="<?= $item['image'] ? '/uploads/products/' . $item['image'] : 'https://placehold.co/70x70?text=Food' ?>" 
                 class="w-100 h-100 object-fit-cover" 
                 alt="<?= htmlspecialchars($item['name']) ?>">
        </div>
        <div>
            <h5 class="fw-bold mb-1 text-dark"><?= htmlspecialchars($item['name']) ?></h5>
            <p class="text-muted small mb-0 fw-medium">$<?= number_format($item['price'], 2) ?> / unit</p>
        </div>
    </div>
    
    <div class="d-flex align-items-center gap-4">
        <!-- Quantity Control -->
        <div class="input-group input-group-sm rounded-pill border py-1 px-2 bg-light shadow-sm" style="width: 110px;">
            <button class="btn btn-sm btn-link text-dark p-0 btn-qty-down" data-id="<?= $item['id'] ?>"><i class="bi bi-dash fs-5"></i></button>
            <input type="text" class="form-control bg-transparent border-0 text-center fw-black qty-input" 
                   value="<?= $item['quantity'] ?>" readonly>
            <button class="btn btn-sm btn-link text-warning p-0 btn-qty-up" data-id="<?= $item['id'] ?>"><i class="bi bi-plus fs-5"></i></button>
        </div>
        
        <!-- Total for Item -->
        <div class="text-end" style="min-width: 90px;">
            <h5 class="fw-bold mb-0 text-dark">$<?= number_format($item['price'] * $item['quantity'], 2) ?></h5>
        </div>
        
        <!-- Quick Action -->
        <button class="btn btn-link text-danger p-0 border-0 btn-remove" data-id="<?= $item['id'] ?>" title="Remove item">
            <i class="bi bi-trash-fill fs-4"></i>
        </button>
    </div>
</div>
