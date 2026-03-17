<?php
/**
 * Cart Item Component
 * 
 * @param array $item Cart item data (id, name, price, quantity)
 */
?>
<div class="card mb-3 border-0 shadow-sm cart-item-card">
    <div class="card-body p-3">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div class="cart-item-info">
                    <h6 class="fw-bold mb-1"><?php echo $item['name']; ?></h6>
                    <span class="text-muted fw-bold">$<?php echo number_format($item['price'], 2); ?></span>
                </div>
            </div>
            
            <div class="d-flex align-items-center gap-4">
                <div class="quantity-controls d-flex align-items-center bg-light rounded-pill px-2 py-1">
                    <button class="btn btn-sm p-0 px-2 btn-decrease border-0" data-id="<?php echo $item['id']; ?>">
                        <i class="bi bi-dash"></i>
                    </button>
                    <span class="fw-bold mx-2" style="min-width: 20px; text-align: center;"><?php echo $item['quantity']; ?></span>
                    <button class="btn btn-sm p-0 px-2 btn-increase border-0" data-id="<?php echo $item['id']; ?>">
                        <i class="bi bi-plus"></i>
                    </button>
                </div>
                
                <div class="text-end" style="min-width: 80px;">
                    <span class="fw-bold text-dark">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                </div>
                
                <button class="btn btn-link text-danger p-0 btn-remove" data-id="<?php echo $item['id']; ?>">
                    <i class="bi bi-trash fs-5"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .cart-item-card {
        border-radius: 12px;
        transition: transform 0.2s ease;
    }
    .cart-item-card:hover {
        transform: scale(1.01);
    }
    .quantity-controls {
        background-color: #f8f9fa !important;
    }
    .quantity-controls button:hover {
        color: #F59E0B;
    }
</style>
