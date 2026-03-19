<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm py-3 px-4">
    <div class="container-fluid">
        <?php
        $role = $_SESSION['user']['role'] ?? null;
        $currentPage = $_GET['page'] ?? 'home';
        ?>

         <a class="navbar-brand fw-bold d-flex align-items-center" href="<?= $role === 'admin' ? 'index.php?page=admin-dashboard' : 'index.php?page=home' ?>">
            <i class="bi bi-cup-hot-fill me-2 text-warning fs-3"></i>
            <span style="letter-spacing: 1px; font-size: 1.4rem;">Cafeteria</span>
        </a>

         <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

         <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1 mt-2 mt-lg-0">

                <?php if (isset($_SESSION['user']) && $role === 'admin'): ?>
                     <li class="nav-item">
                        <a class="nav-link px-3 rounded-pill transition-all <?= $currentPage === 'admin-dashboard' ? 'active bg-warning text-dark fw-bold' : 'text-white' ?>"
                           href="index.php?page=admin-dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 rounded-pill transition-all <?= $currentPage === 'admin-orders' ? 'active bg-warning text-dark fw-bold' : 'text-white' ?>"
                           href="index.php?page=admin-orders">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 rounded-pill transition-all <?= $currentPage === 'admin-products' ? 'active bg-warning text-dark fw-bold' : 'text-white' ?>"
                           href="index.php?page=admin-products">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 rounded-pill transition-all <?= $currentPage === 'admin-categories' ? 'active bg-warning text-dark fw-bold' : 'text-white' ?>"
                           href="index.php?page=admin-categories">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 rounded-pill transition-all <?= $currentPage === 'admin-rooms' ? 'active bg-warning text-dark fw-bold' : 'text-white' ?>"
                           href="index.php?page=admin-rooms">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 rounded-pill transition-all <?= $currentPage === 'admin-users' ? 'active bg-warning text-dark fw-bold' : 'text-white' ?>"
                           href="index.php?page=admin-users">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 rounded-pill transition-all <?= $currentPage === 'admin-checks' ? 'active bg-warning text-dark fw-bold' : 'text-white' ?>"
                           href="index.php?page=admin-checks">Reports</a>
                    </li>

                <?php elseif (isset($_SESSION['user'])): ?>
                     <li class="nav-item">
                        <a class="nav-link px-3 rounded-pill transition-all <?= $currentPage === 'home' ? 'active bg-warning text-dark fw-bold' : 'text-white' ?>"
                           href="index.php?page=home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 rounded-pill transition-all <?= $currentPage === 'orders' ? 'active bg-warning text-dark fw-bold' : 'text-white' ?>"
                           href="index.php?page=orders">My Orders (Track Status)</a>
                    </li>
                <?php endif; ?>

            </ul>

             <ul class="navbar-nav ms-auto align-items-center gap-3">
                <?php if (isset($_SESSION['user'])): ?>
                    
                    <?php if ($role === 'user'): ?>
                         <li class="nav-item me-2">
                            <a href="index.php?page=cart" class="nav-link position-relative d-flex align-items-center bg-dark-subtle px-3 py-2 rounded-pill border border-secondary transition-all">
                                <i class="bi bi-cart3 text-warning fs-5"></i>
                                <span class="ms-2 d-none d-md-inline small fw-bold text-white">My Cart</span>
                                <span id="cart-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light" style="font-size: 0.65rem; display: none;">0</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item d-flex align-items-center gap-2">
                        <div class="rounded-circle border border-warning border-2 p-0 shadow-sm" style="width: 38px; height: 38px; overflow: hidden;">
                            <?php
                            $userImage = $_SESSION['user']['image'] ?? 'default.png';
                            $imagePath = "/cafeteria-system-develop/uploads/users/" . $userImage;
                            ?>
                            <img src="<?= $imagePath ?>" alt="Profile" class="w-100 h-100" style="object-fit:cover;" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['user']['name'] ?? 'User') ?>&background=F59E0B&color=fff'">
                        </div>
                        <div class="d-none d-md-block">
                            <div class="text-white fw-bold small" style="line-height: 1;"><?= htmlspecialchars($_SESSION['user']['name'] ?? 'Account') ?></div>
                            <div class="text-warning extra-small fw-semibold" style="font-size: 0.65rem; text-transform: uppercase;"><?= $role ?></div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?page=logout" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold">
                            Logout <i class="bi bi-box-arrow-right ms-1"></i>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="index.php?page=login" class="btn btn-warning rounded-pill px-4 fw-bold shadow-sm">
                            Sign In <i class="bi bi-box-arrow-in-right ms-1"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<style>
    .transition-all { transition: all 0.2s ease-in-out; }
    .extra-small { font-size: 0.7rem; }
    .nav-link:hover:not(.active) { color: #F59E0B !important; transform: translateY(-1px); }
</style>