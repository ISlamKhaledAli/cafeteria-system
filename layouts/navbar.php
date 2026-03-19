<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm py-3 px-4 sticky-top">
    <div class="container-fluid">
        <?php
        $role = $_SESSION['user']['role'] ?? null;
        $currentPage = $_GET['page'] ?? 'home';
        ?>

        <a class="navbar-brand fw-bold d-flex align-items-center transition-all hover-scale" href="index.php?page=<?= $role === 'admin' ? 'admin-dashboard' : 'home' ?>">
            <i class="bi bi-cup-hot-fill me-2 text-warning fs-3"></i>
            <span style="letter-spacing: 1px; font-size: 1.4rem;">Cafeteria</span>
        </a>

        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1 mt-2 mt-lg-0">
                <?php if (isset($_SESSION['user']) && $role === 'admin'): ?>
                    <?php 
                        $adminLinks = [
                            'admin-dashboard' => 'Dashboard',
                            'admin-orders'    => 'Orders',
                            'admin-products'  => 'Products',
                            'admin-categories'=> 'Categories',
                            'admin-rooms'     => 'Rooms',
                            'admin-users'     => 'Users',
                            'admin-checks'    => 'Reports'
                        ];
                        foreach ($adminLinks as $key => $label):
                    ?>
                    <li class="nav-item">
                        <a class="nav-link px-3 rounded-pill transition-all <?= $currentPage === $key ? 'active bg-warning text-dark fw-bold shadow-sm' : 'text-white hover-text-warning' ?>"
                           href="index.php?page=<?= $key ?>"><?= $label ?></a>
                    </li>
                    <?php endforeach; ?>

                <?php elseif (isset($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <a class="nav-link px-3 rounded-pill transition-all <?= $currentPage === 'home' ? 'active bg-warning text-dark fw-bold shadow-sm' : 'text-white hover-text-warning' ?>"
                           href="index.php?page=home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 rounded-pill transition-all <?= $currentPage === 'my-orders' ? 'active bg-warning text-dark fw-bold shadow-sm' : 'text-white hover-text-warning' ?>"
                           href="index.php?page=my-orders">My Orders</a>
                    </li>
                <?php endif; ?>
            </ul>

            <ul class="navbar-nav ms-auto align-items-center gap-3">
                <?php if (isset($_SESSION['user'])): ?>
                    
                    <?php if ($role === 'user'): ?>
                        <li class="nav-item me-2">
                            <a href="index.php?page=cart" class="nav-link position-relative d-flex align-items-center bg-dark-subtle px-3 py-2 rounded-pill border border-secondary transition-all hover-scale">
                                <i class="bi bi-cart3 text-warning fs-5"></i>
                                <span class="ms-2 d-none d-md-inline small fw-bold text-white">Cart</span>
                                <span id="cart-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light" style="font-size: 0.65rem; display: none; transition: transform 0.2s ease;">0</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item d-flex align-items-center gap-2">
                        <div class="rounded-circle border border-warning border-2 p-0 shadow-sm transition-all hover-scale" style="width: 38px; height: 38px; overflow: hidden; background: #fff;">
                            <?php
                            $userImage = $_SESSION['user']['image'] ?? 'default.png';
                            $imagePath = "uploads/users/" . $userImage;
                            // التأكد إن الصورة موجودة فعلاً في السيرفر، لو لأ بنستخدم الـ API
                            if (!file_exists(BASE_PATH . '/' . $imagePath) || $userImage === 'default.png') {
                                $displayImage = "https://ui-avatars.com/api/?name=" . urlencode($_SESSION['user']['name'] ?? 'User') . "&background=F59E0B&color=fff";
                            } else {
                                // استخدام مسار نسبي آمن
                                $displayImage = $imagePath;
                            }
                            ?>
                            <img src="<?= $displayImage ?>" alt="Profile" class="w-100 h-100" style="object-fit:cover;">
                        </div>
                        <div class="d-none d-md-block">
                            <div class="text-white fw-bold small" style="line-height: 1;"><?= htmlspecialchars($_SESSION['user']['name'] ?? 'Account') ?></div>
                            <div class="text-warning fw-semibold" style="font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.5px;"><?= $role ?></div>
                        </div>
                    </li>
                    <li class="nav-item ms-2">
                        <a href="index.php?page=logout" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold transition-all hover-scale">
                            Logout <i class="bi bi-box-arrow-right ms-1"></i>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="index.php?page=login" class="btn btn-warning rounded-pill px-4 fw-bold shadow-sm transition-all hover-scale">
                            Sign In <i class="bi bi-box-arrow-in-right ms-1"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>