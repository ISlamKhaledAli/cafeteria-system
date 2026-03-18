<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm py-3">
    <div class="container">
        <?php if (isset($_SESSION['user'])): ?>
            <!-- FIXED: Show Profile only when logged in -->
            <div class="d-flex align-items-center me-3 animate-fade-in">
                <div class="rounded-circle overflow-hidden border border-warning border-2" style="width: 40px; height: 40px;">
                    <?php 
                    $userImage = $_SESSION['user']['image'] ?? 'default.png';
                    $imagePath = "uploads/users/" . $userImage;
                    if (!file_exists(BASE_PATH . '/' . $imagePath) || $userImage == 'default.png') {
                        $imagePath = "https://ui-avatars.com/api/?name=" . urlencode($_SESSION['user']['name'] ?? 'User') . "&background=F59E0B&color=fff";
                    }
                    ?>
                    <img src="<?= $imagePath ?>" alt="Profile" class="w-100 h-100 object-fit-cover">
                </div>
                <span class="ms-2 text-white fw-semibold d-none d-md-inline"><?= htmlspecialchars($_SESSION['user']['name']) ?></span>
            </div>
        <?php endif; ?>

        <a class="navbar-brand fw-bold me-auto" href="index.php?page=home">
            <i class="bi bi-cup-hot-fill me-2 text-warning"></i>Cafeteria
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto gap-3">
                <li class="nav-item">
                    <a class="nav-link text-white fw-semibold" href="index.php?page=home">Home</a>
                </li>
                <?php if (isset($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="index.php?page=orders">My Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="index.php?page=logout">
                            <i class="bi bi-box-arrow-right me-1 text-danger"></i>Logout
                        </a>
                    </li>
                <?php else: ?>
                    <!-- FIXED: Show Login button when logged out -->
                    <li class="nav-item">
                        <a class="btn btn-warning rounded-pill px-4 fw-bold" href="index.php?page=login" style="background-color: #F59E0B; border: none;">
                            Login <i class="bi bi-box-arrow-in-right ms-1"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<style>
    .navbar-dark .navbar-nav .nav-link:hover { color: var(--primary-orange) !important; }
    .animate-fade-in { animation: fadeIn 0.3s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateX(-10px); } to { opacity: 1; transform: translateX(0); } }
</style>