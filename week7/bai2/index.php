<?php
require_once __DIR__ . '/Database.php';

$db = Database::getInstance();
$products = $db->select("SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ - Cửa Hàng Sản Phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php"><i class="bi bi-shop"></i> MiniShop</a>
        <div class="ms-auto">
            <a href="index.php" class="btn btn-outline-light me-2 active">Trang Chủ</a>
            <a href="admin_products.php" class="btn btn-warning"><i class="bi bi-gear-fill"></i> Quản Lý Sản Phẩm</a>
        </div>
    </div>
</nav>

<!-- Banner Header -->
<header class="bg-primary text-white py-5 mb-4 shadow-sm">
    <div class="container text-center">
        <h1 class="display-5 fw-bold">Danh Sách Sản Phẩm</h1>
        <p class="lead mb-0">Khám phá các sản phẩm hot nhất hôm nay</p>
    </div>
</header>

<!-- Danh sách sản phẩm -->
<main class="container mb-5">
    <?php if (empty($products)): ?>
        <div class="alert alert-info text-center">Hiện chưa có sản phẩm nào trong hệ thống!</div>
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
    <div class="container">&copy; 2026 MiniShop - Bài 2: Quản lý sản phẩm</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
