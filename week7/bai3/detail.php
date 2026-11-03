<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/auth.php';

$db = Database::getInstance();
$id = (int)($_GET['id'] ?? 0);

$product = $db->select("SELECT * FROM products WHERE id = ?", "i", [$id]);

if (empty($product)) {
    die("<div class='container mt-5'><div class='alert alert-danger'>Không tìm thấy sản phẩm! <a href='index.php'>Quay về</a></div></div>");
}

$p = $product[0];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sản Phẩm - <?= htmlspecialchars($p['name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php"><i class="bi bi-laptop"></i> TechShop</a>
        <div class="ms-auto d-flex align-items-center gap-2">
            <a href="index.php" class="btn btn-outline-light btn-sm">Trang Chủ</a>
            <?php if (isAdmin()): ?>
                <a href="admin_products.php" class="btn btn-warning btn-sm"><i class="bi bi-gear-fill"></i> Quản Trị</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($p['name']) ?></li>
        </ol>
    </nav>

    <div class="card shadow-sm border-0 overflow-hidden">
        <div class="row g-0">
            <div class="col-md-5 bg-white d-flex align-items-center justify-content-center p-3">
                <img src="<?= htmlspecialchars($p['image']) ?>" 
                     class="img-fluid rounded object-fit-cover w-100" 
                     style="max-height: 400px;"
                     alt="<?= htmlspecialchars($p['name']) ?>"
                     onerror="this.src='https://dummyimage.com/500x400/dee2e6/6c757d.jpg&text=No+Image'">
            </div>
            <div class="col-md-7">
                <div class="card-body p-4 p-lg-5">
                    <span class="badge bg-secondary mb-2">Mã SP: <?= htmlspecialchars($p['code']) ?></span>
                    <h2 class="card-title fw-bold text-dark"><?= htmlspecialchars($p['name']) ?></h2>
                    
                    <h3 class="text-danger fw-bold my-3">
                        <?= number_format($p['price'], 0, ',', '.') ?> VNĐ
                    </h3>

                    <div class="mb-4">
                        <h6 class="fw-bold text-muted">Mô tả sản phẩm:</h6>
                        <p class="card-text text-secondary" style="white-space: pre-line;">
                            <?= nl2br(htmlspecialchars($p['description'] ?: 'Chưa có thông tin mô tả chi tiết.')) ?>
                        </p>
                    </div>

                    <div class="d-flex gap-2 pt-3 border-top">
                        <a href="index.php" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Quay lại
                        </a>
                        <?php if (isAdmin()): ?>
                            <a href="product_edit.php?id=<?= $p['id'] ?>" class="btn btn-warning">
                                <i class="bi bi-pencil-square"></i> Sửa sản phẩm
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="bg-white text-center py-4 border-top mt-auto text-muted">
    <div class="container">&copy; 2026 TechShop - Màn hình chi tiết sản phẩm</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
