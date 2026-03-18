<?php
/**
 * User Cart Page - Checkout Layout
 * FIXED: Sync with cart.js and design system consistency.
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Order - Cafeteria</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root { --primary-orange: #F59E0B; --bg-gray: #F8F7F6; }
        body { background-color: var(--bg-gray); font-family: 'Inter', sans-serif; }
        .checkout-card { border: none; border-radius: 24px; }
        .btn-confirm { background-color: #F59E0B; color: white; border: none; transition: all 0.3s; }
        .btn-confirm:hover { background-color: #D97706; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(245, 158, 11, 0.3); }
        .btn-confirm:disabled { background-color: #E5E7EB; color: #9CA3AF; transform: none; box-shadow: none; cursor: not-allowed; }
    </style>
</head>
<body>
    <?php include BASE_PATH . '/layouts/navbar.php'; ?>
    <script>window.userId = <?= json_encode($_SESSION['user']['id']) ?>;</script>

    <div class="container py-5 mt-4">
        <div class="mb-4">
            <a href="index.php?page=home" class="text-decoration-none text-muted fw-semibold">
                <i class="bi bi-arrow-left me-2"></i> Back to Menu
            </a>
        </div>

        <h1 class="fw-bold mb-5">Review Your <span class="text-warning">Order</span></h1>
        
        <div class="row g-4 mb-5">
            <!-- Left Side: Order Items -->
            <div class="col-lg-8">
                <div class="card checkout-card shadow-sm p-4 bg-white h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold m-0">Order Details</h5>
                        <button class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="localStorage.removeItem('user_cart'); window.location.reload();">Clear All</button>
                    </div>
                    <div id="checkout-items-list">
                        <!-- Dynamically populated by cart.js -->
                        <div class="text-center py-5">
                            <div class="spinner-border text-warning" role="status"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Order Summary & Placement -->
            <div class="col-lg-4">
                <div class="card checkout-card shadow-sm p-4 bg-white sticky-top" style="top: 100px;">
                    <h5 class="fw-bold mb-4">Summary</h5>
                    
                    <div class="d-flex justify-content-between mb-3 text-secondary">
                        <span class="fw-medium">Subtotal</span>
                        <span id="cart-total" class="fw-bold text-dark">$0.00</span>
                    </div>
                    
                    <div class="py-4 border-top border-bottom mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold text-muted mb-0">Final Amount</h5>
                            <h2 class="fw-bold mb-0 text-warning" id="cart-total">$0.00</h2>
                        </div>
                    </div>

                    <form id="checkout-form">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Delivery Room</label>
                            <div class="input-group bg-light rounded-3 overflow-hidden border">
                                <span class="input-group-text bg-transparent border-0 pe-1"><i class="bi bi-geo-alt text-warning fs-5"></i></span>
                                <select name="room_no" class="form-select bg-transparent border-0 py-2 fw-semibold" id="room_no" required>
                                    <option value="" disabled selected>Select Target Room</option>
                                    <option value="Meeting Room A">Meeting Room A</option>
                                    <option value="Office 204">Office 204</option>
                                    <option value="Lobby">Lobby Area</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Special Notes</label>
                            <textarea name="notes" class="form-control bg-light border rounded-3" id="notes" rows="4" placeholder="e.g. Please leave at the door..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-confirm w-100 py-3 rounded-pill fw-bold">
                            Place Order Now
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/cart.js"></script>
</body>
</html>
