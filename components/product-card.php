<?php
/**
 * Product Card Component
 * FIXED: Alignment of price badge, image fallback, and button spacing.
 */
?>
<div class="col">
    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden position-relative animate-fade-in bg-white" style="transition: transform 0.3s ease;">
        <!-- Price Badge: Absolute positioned correctly -->
        <div class="position-absolute top-0 end-0 m-3 z-1">
            <span class="badge bg-white text-dark shadow-sm rounded-pill px-3 py-2 fw-bold" style="border: 1px solid #eee;">
                $<?= number_format($product['price'], 2) ?>
            </span>
        </div>
        
        <!-- Image Container -->
        <div class="bg-light" style="height: 200px; overflow: hidden;">
            <?php 
                $image_path = "uploads/products/" . $product['image'];
                $display_image = (!empty($product['image']) && file_exists(BASE_PATH . "/" . $image_path)) 
                    ? $image_path 
                    : 'assets/images/default-product.png';
            ?>
            <img src="<?= $display_image ?>" 
                 class="w-100 h-100 object-fit-cover product-img" 
                 alt="<?= htmlspecialchars($product['name']) ?>"
                 onerror="this.src='https://placehold.co/400x300?text=<?= urlencode($product['name']) ?>'">
        </div>

        <div class="card-body p-4 d-flex flex-column">
            <h5 class="fw-bold text-dark mb-2"><?= htmlspecialchars($product['name']) ?></h5>
            <p class="text-muted small mb-4 flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                <?= htmlspecialchars($product['description'] ?? 'Deliciously prepared using fresh ingredients for your peak performance.') ?>
            </p>
            
            <button class="btn w-100 rounded-pill py-2 fw-bold btn-add-to-cart" 
                    data-id="<?= $product['id'] ?>"
                    data-name="<?= htmlspecialchars($product['name']) ?>"
                    data-price="<?= $product['price'] ?>"
                    data-image="<?= $product['image'] ?>"
                    style="background-color: #FFF7ED; color: #F59E0B; border: none; transition: all 0.2s;">
                <i class="bi bi-plus-lg me-2"></i>Add to Order
            </button>
        </div>
    </div>
</div>

<style>
    .card:hover { transform: translateY(-5px); box-shadow: 0 1rem 3rem rgba(0,0,0,.08) !important; }
    .card:hover .btn-add-to-cart { background-color: #F59E0B !important; color: white !important; }
    .product-img { transition: transform 0.5s ease; }
    .card:hover .product-img { transform: scale(1.1); }
</style>
