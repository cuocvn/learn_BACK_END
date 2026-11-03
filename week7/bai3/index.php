<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/auth.php';

$db = Database::getInstance();
$products = $db->select("SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ - TechShop Week 7</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php"><i class="bi bi-laptop"></i> TechShop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Trang Chủ</a>
                </li>
                <?php if (isAdmin()): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-warning fw-bold" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-shield-lock-fill"></i> Quản Trị Admin
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="admin_products.php"><i class="bi bi-box-seam"></i> Quản lý sản phẩm</a></li>
                            <li><a class="dropdown-item" href="admin_users.php"><i class="bi bi-people-fill"></i> Quản lý người dùng</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>

            <div class="d-flex align-items-center gap-2">
                <?php if (isLoggedIn()): ?>
                    <span class="text-white me-2">
                        Xin chào, <strong><?= htmlspecialchars($_SESSION['user']['username']) ?></strong>
                        <?php if (isAdmin()): ?>
                            <span class="badge bg-danger">Admin</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">User</span>
                        <?php endif; ?>
                    </span>
                    <a href="logout.php" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Đăng Xuất
                    </a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-box-arrow-in-right"></i> Đăng Nhập
                    </a>
                    <a href="register.php" class="btn btn-primary btn-sm">
                        <i class="bi bi-person-plus"></i> Đăng Ký
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- Hero header -->
<header class="bg-primary text-white py-5 mb-4 shadow-sm">
    <div class="container text-center">
        <h1 class="display-5 fw-bold">Khám Phá Thiết Bị Công Nghệ</h1>
        <p class="lead mb-0">Hệ thống bài 3: Phân quyền Admin quản lý Sản phẩm & Người dùng</p>
    </div>
</header>

<!-- Danh sách sản phẩm -->
<main class="container mb-5">
    <?php if (empty($products)): ?>
        <div class="alert alert-info text-center">Hiện chưa có sản phẩm nào.</div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php foreach ($products as $p): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="<?= htmlspecialchars($p['image']) ?>" 
                             class="card-img-top object-fit-cover" 
                             alt="<?= htmlspecialchars($p['name']) ?>" 
                             style="height: 200px;"
                             onerror="this.src='https://dummyimage.com/450x300/dee2e6/6c757d.jpg&text=No+Image'">
                        <div class="card-body d-flex flex-column text-center">
                            <span class="badge bg-secondary mb-2 align-self-center"><?= htmlspecialchars($p['code']) ?></span>
                            <h5 class="card-title fw-bold text-truncate" title="<?= htmlspecialchars($p['name']) ?>">
                                <?= htmlspecialchars($p['name']) ?>
                            </h5>
                            <p class="card-text text-danger fs-5 fw-bold mb-3">
                                <?= number_format($p['price'], 0, ',', '.') ?> VNĐ
                            </p>
                            <a href="detail.php?id=<?= $p['id'] ?>" class="btn btn-outline-primary mt-auto">
                                <i class="bi bi-eye"></i> Xem Chi Tiết
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<footer class="bg-white text-center py-4 border-top mt-auto text-muted">
    <div class="container">&copy; 2026 TechShop - Bài 3: Phân quyền người dùng & Quản lý</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
