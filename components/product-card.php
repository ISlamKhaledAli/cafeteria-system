<?php
/**
 * Product Card Component
 * 
 * @param string $name Product Name
 * @param float $price Product Price
 * @param string $image Product Image URL
 */
?>
<div class="col">
    <div class="card h-100 border-0 shadow-sm product-card transition-hover">
        <div class="position-relative overflow-hidden">
            <img src="<?php echo $image; ?>" class="card-img-top product-image" alt="<?php echo $name; ?>" style="height: 200px; object-fit: cover;">
            <div class="product-badge position-absolute top-0 start-0 m-2">
                <span class="badge bg-warning text-dark px-2 py-1 shadow-sm" style="background-color: #F59E0B !important;">New</span>
            </div>
        </div>
        <div class="card-body d-flex flex-column p-4">
            <h5 class="card-title fw-bold mb-2"><?php echo $name; ?></h5>
            <div class="d-flex justify-content-between align-items-center mt-auto">
                <span class="fs-4 fw-bold text-dark">$<?php echo number_format($price, 2); ?></span>
                <button class="btn btn-primary rounded-pill px-4 py-2 add-to-cart-btn" style="background-color: #F59E0B; border-color: #F59E0B;">
                    <i class="bi bi-plus-lg me-1"></i> Add to Cart
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 12px;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .product-image {
        transition: transform 0.5s ease;
    }
    .product-card:hover .product-image {
        transform: scale(1.05);
    }
    .add-to-cart-btn:hover {
        background-color: #D97706 !important;
        border-color: #D97706 !important;
    }
</style>
