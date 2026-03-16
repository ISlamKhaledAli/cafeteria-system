<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart - Cafeteria System</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-orange: #F59E0B;
            --bg-light-gray: #F3F4F6;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light-gray);
            color: #1F2937;
        }

        .btn-confirm {
            background-color: var(--primary-orange);
            border-color: var(--primary-orange);
            color: white;
            font-weight: 600;
        }

        .btn-confirm:hover {
            background-color: #D97706;
            border-color: #D97706;
            color: white;
        }

        .section-title {
            font-weight: 700;
            color: #111827;
            border-left: 5px solid var(--primary-orange);
            padding-left: 1rem;
        }

        .summary-card {
            border-radius: 16px;
            position: sticky;
            top: 2rem;
        }

        .form-select, .form-control {
            border-radius: 10px;
            border: 1px solid #E5E7EB;
            padding: 0.75rem;
        }

        .form-select:focus, .form-control:focus {
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 0.25rem rgba(245, 158, 11, 0.1);
        }
    </style>
</head>
<body>

<div class="container py-5">
    <!-- Back to Home -->
    <div class="mb-4">
        <a href="home.php" class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-1"></i> Back to Menu
        </a>
    </div>

    <div class="row g-4">
        <!-- Left Panel: Cart Items -->
        <div class="col-lg-8">
            <h2 class="section-title mb-4">Your Cart</h2>
            <div id="cart-items">
                <!-- Items will be injected here by cart.js -->
                <div class="text-center text-muted py-5 bg-white rounded-3 shadow-sm">
                    <i class="bi bi-cart fs-1 d-block mb-3"></i>
                    Your cart is empty
                </div>
            </div>
        </div>

        <!-- Right Panel: Order Summary -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 summary-card">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4 text-center">Order Summary</h4>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-bold" id="cart-subtotal">$0.00</span>
                    </div>
                    <!-- Delivery could be added here if needed -->
                    <hr class="my-4">
                    <div class="d-flex justify-content-between mb-4">
                        <h5 class="fw-bold mb-0">Total</h5>
                        <h4 class="fw-bold mb-0 text-primary" id="cart-total" style="color: var(--primary-orange) !important;">$0.00</h4>
                    </div>

                    <form id="order-form">
                        <div class="mb-3">
                            <label for="room" class="form-label fw-bold">Delivery Room</label>
                            <select class="form-select" id="room" required>
                                <option value="" selected disabled>Select a room</option>
                                <option value="1">Room 1</option>
                                <option value="2">Room 2</option>
                                <option value="3">Room 3</option>
                                <option value="4">Room 4</option>
                                <option value="5">Room 5</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="form-label fw-bold">Notes</label>
                            <textarea class="form-control" id="notes" rows="3" placeholder="Any special requests?"></textarea>
                        </div>

                        <button type="submit" class="btn btn-confirm w-100 py-3 rounded-pill">
                            Confirm Order
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/cart.js"></script>
<script>
    // Note: The cart.js script already has a renderCart function.
    // However, the cart.js logic is currently hardcoded for the sidebar IDs.
    // We might need to adjust cart.js or provide a page-specific render.
</script>
</body>
</html>
