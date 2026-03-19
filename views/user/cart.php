<?php
 
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/navbar.php';
?>

<div class="container py-5 px-4" style="background-color: #fcfcfc; min-height: 100vh;">
    <script>window.userId = <?= json_encode($_SESSION['user']['id']) ?>;</script>

    <div class="mb-5 d-flex align-items-center gap-3">
        <a href="index.php?page=home" class="btn btn-white bg-white border rounded-circle shadow-sm p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
            <i class="bi bi-arrow-left text-dark fs-5"></i>
        </a>
        <h2 class="fw-bold mb-0">Confirm Your <span class="text-warning">Order</span></h2>
    </div>

    <div class="row g-5">
         <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 28px; background: #fff;">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-4">
                    <h5 class="fw-bold mb-0">Order Summary</h5>
                    <button class="btn btn-sm btn-light text-danger fw-bold rounded-pill px-4 border" onclick="Swal.fire({title:'Clear Cart?', icon:'warning', showCancelButton:true}).then(r=>{if(r.isConfirmed){localStorage.removeItem('user_cart'); location.reload();}})">
                        <i class="bi bi-trash3 me-1"></i> Clear All
                    </button>
                </div>

                <div id="checkout-items-list" class="pe-2">
                     <div class="text-center py-5">
                        <div class="spinner-border text-warning" role="status"></div>
                    </div>
                </div>
            </div>
        </div>

         <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4 sticky-top" style="border-radius: 28px; top: 100px; background: #fff;">
                <form id="checkout-form">
                    <h5 class="fw-bold mb-4">Complete Details</h5>

                     <div class="mb-4">
                        <label class="form-label extra-small fw-bold text-muted text-uppercase mb-2" style="letter-spacing: 0.5px;">Delivery Room</label>
                        <div class="input-group shadow-sm bg-light" style="border-radius: 12px; overflow: hidden; border: 1px solid #eee;">
                            <span class="input-group-text bg-transparent border-0"><i class="bi bi-geo-alt-fill text-warning"></i></span>
                            <select name="room_no" class="form-select border-0 bg-transparent py-2 fw-bold" id="room_select" required>
                                <?php 
                                $user_db = Database::getInstance()->getConnection();
                                try {
                                    $room_stmt = $user_db->query("SELECT name FROM rooms ORDER BY name ASC");
                                    $dynamic_rooms = $room_stmt->fetchAll(PDO::FETCH_COLUMN) ?: ['101', '102', 'Lobby'];
                                } catch (PDOException $e) {
                                    $room_stmt = $user_db->query("SELECT DISTINCT room_no FROM users WHERE room_no IS NOT NULL AND room_no != '' ORDER BY room_no ASC");
                                    $dynamic_rooms = $room_stmt->fetchAll(PDO::FETCH_COLUMN) ?: ['101', '102', 'Lobby'];
                                }
                                foreach ($dynamic_rooms as $room): 
                                ?>
                                    <option value="<?= htmlspecialchars($room) ?>"><?= htmlspecialchars($room) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                     <div class="mb-5">
                        <label class="form-label extra-small fw-bold text-muted text-uppercase mb-2" style="letter-spacing: 0.5px;">Special Instructions</label>
                        <textarea name="notes" class="form-control border-0 bg-light shadow-sm p-3" id="notes" rows="3" placeholder="No sugar, extra ice..." style="border-radius: 12px; font-size: 0.9rem;"></textarea>
                    </div>

                     <div class="d-flex justify-content-between mb-2 text-muted fw-semibold extra-small">
                        <span>Total Items Price</span>
                        <span id="cart-total">0.00 EGP</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <h4 class="fw-bold text-dark">Grand Total</h4>
                        <h4 class="fw-bold text-warning" id="cart-total">0.00 EGP</h4>
                    </div>

                    <button type="submit" id="btn-checkout" class="btn btn-warning w-100 py-3 rounded-pill fw-bold shadow-sm transition-all text-dark">
                        Confirm & Place Order <i class="bi bi-check2-all ms-2"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .extra-small { font-size: 0.65rem; }
    .transition-all { transition: all 0.3s ease; }
    .btn-warning:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(245, 158, 11, 0.2) !important; filter: brightness(1.05); }
</style>

<script src="assets/js/cart.js"></script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
