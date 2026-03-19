<?php
 
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/navbar.php';
require_once BASE_PATH . '/models/Product.php';

$productModel = new Product();
$products = $productModel->getAllProducts();
$categories = $productModel->getCategories();

 $user_db = Database::getInstance()->getConnection();
try {
    $room_stmt = $user_db->query("SELECT name FROM rooms ORDER BY name ASC");
    $dynamic_rooms = $room_stmt->fetchAll(PDO::FETCH_COLUMN) ?: ['101', '102', 'Lobby'];
} catch (PDOException $e) {
     $room_stmt = $user_db->query("SELECT DISTINCT room_no FROM users WHERE room_no IS NOT NULL AND room_no != '' ORDER BY room_no ASC");
    $dynamic_rooms = $room_stmt->fetchAll(PDO::FETCH_COLUMN) ?: ['101', '102', 'Lobby'];
}
?>

<div class="container py-5 px-4" style="background-color: #fcfcfc; min-height: 100vh;">
    <script>window.userId = <?= json_encode($_SESSION['user']['id']) ?>;</script>

     <div class="row align-items-center mb-5 g-4">
        <div class="col-md-6">
            <h1 class="fw-bold mb-1 text-dark">Premium <span class="text-warning">Cafeteria</span></h1>
            <p class="text-muted small mb-0">Discover our fresh menu and enjoy your break.</p>
        </div>
        <div class="col-md-6 d-flex justify-content-md-end gap-3 align-items-center">
             <div class="bg-white border shadow-sm px-4 py-2 rounded-pill d-flex align-items-center gap-3">
                <i class="bi bi-geo-alt-fill text-warning"></i>
                <div>
                    <div class="extra-small text-muted fw-bold text-uppercase">Delivery Room</div>
                    <select id="room_select" class="form-select form-select-sm border-0 bg-transparent p-0 shadow-none fw-bold" style="font-size: 0.85rem;" onchange="syncRoom(this.value)">
                        <?php foreach ($dynamic_rooms as $room): ?>
                            <option value="<?= htmlspecialchars($room) ?>"><?= htmlspecialchars($room) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="position-relative d-none d-lg-block">
                <i class="fas fa-search position-absolute text-muted" style="top: 50%; left: 15px; transform: translateY(-50%);"></i>
                <input type="text" id="menuSearch" class="form-control ps-5 bg-white border-0 shadow-sm" 
                       placeholder="Search snacks..." style="border-radius: 30px; width: 220px;">
            </div>
        </div>
    </div>

     <div class="d-flex overflow-auto gap-2 mb-5 pb-2 category-scroll" style="scrollbar-width: thin;">
        <button class="btn btn-warning rounded-pill px-4 fw-bold shadow-sm category-filter active" data-category="all">All Items</button>
        <?php foreach ($categories as $cat): ?>
            <button class="btn btn-white bg-white border rounded-pill px-4 fw-semibold shadow-sm category-filter" 
                    data-category="<?= htmlspecialchars($cat['name']) ?>">
                <?= htmlspecialchars($cat['name']) ?>
            </button>
        <?php endforeach; ?>
    </div>

     <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4" id="product-grid">
        <?php foreach ($products as $p): 
            $img = !empty($p['image']) ? $p['image'] : 'default.png';
            $imgURL = "/cafeteria-system-develop/uploads/products/" . $img;
            $catName = htmlspecialchars($p['category_name'] ?? 'Beverage');
        ?>
            <div class="col product-item" data-category="<?= $catName ?>">
                <div class="card h-100 border-0 shadow-sm transition-hover" style="border-radius: 24px; overflow: hidden; background-color: #ffffff;">
                    <div class="position-relative">
                        <img src="<?= $imgURL ?>" class="card-img-top" alt="<?= htmlspecialchars($p['product_name']) ?>" 
                             style="height: 160px; object-fit: cover;" onerror="this.src='https://placehold.co/400x300?text=Product'">
                        <div class="position-absolute top-0 end-0 m-2">
                            <span class="badge bg-white text-warning shadow-sm rounded-pill px-3 py-2 fw-bold" style="font-size: 0.8rem;">
                                <?= number_format($p['price'], 2) ?> <small>EGP</small>
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-3 text-center">
                        <div class="extra-small text-muted fw-bold text-uppercase mb-1"><?= $catName ?></div>
                        <h6 class="card-title fw-bold text-dark mb-3"><?= htmlspecialchars($p['product_name']) ?></h6>
                        
                        <button class="btn btn-light w-100 rounded-pill fw-bold text-warning border border-warning hover-yellow btn-add-to-cart transition-all" 
                                data-id="<?= $p['id'] ?>" 
                                data-name="<?= htmlspecialchars($p['product_name']) ?>" 
                                data-price="<?= $p['price'] ?>" 
                                data-image="<?= $img ?>">
                            <i class="bi bi-cart-plus me-1"></i> Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    .transition-hover { transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.3s ease; }
    .transition-hover:hover { transform: translateY(-8px); box-shadow: 0 15px 30px rgba(0,0,0,0.08) !important; }
    .hover-yellow:hover { background-color: #F59E0B !important; color: white !important; }
    .category-scroll::-webkit-scrollbar { height: 4px; }
    .category-scroll::-webkit-scrollbar-thumb { background: #E5E7EB; border-radius: 10px; }
    .extra-small { font-size: 0.65rem; }
    .category-filter.active { background-color: #F59E0B !important; border-color: #F59E0B !important; color: white !important; }
</style>

<script src="assets/js/cart.js"></script>
<script>
 document.querySelectorAll('.category-filter').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.category-filter').forEach(b => b.classList.remove('active', 'btn-warning'));
        document.querySelectorAll('.category-filter').forEach(b => b.classList.add('btn-white'));
        
        this.classList.add('active', 'btn-warning');
        this.classList.remove('btn-white');

        const cat = this.dataset.category;
        document.querySelectorAll('.product-item').forEach(item => {
            if (cat === 'all' || item.dataset.category === cat) {
                item.style.display = '';
                item.classList.add('animate-fade-in');
            } else {
                item.style.display = 'none';
            }
        });
    });
});

 document.getElementById('menuSearch')?.addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.product-item').forEach(item => {
        item.style.display = item.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});

 function syncRoom(val) {
    localStorage.setItem('selected_room', val);
}

 document.addEventListener('DOMContentLoaded', () => {
    const savedRoom = localStorage.getItem('selected_room');
    if (savedRoom) {
        const select = document.getElementById('room_select');
        if (select) select.value = savedRoom;
    } else {
        localStorage.setItem('selected_room', document.getElementById('room_select').value);
    }
});
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
