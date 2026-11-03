<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/auth.php';
requireAdmin();

$db = Database::getInstance();

// Xử lý XÓA sản phẩm
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = (int)($_GET['id'] ?? 0);
    if ($id > 0) {
        $db->execute("DELETE FROM products WHERE id = ?", "i", [$id]);
        header("Location: admin_products.php?msg=deleted");
        exit;
    }
}

$products = $db->select("SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Quản Lý Sản Phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php"><i class="bi bi-laptop"></i> TechShop</a>
        <div class="collapse navbar-collapse show" id="navMenu">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Trang Chủ</a></li>
                <li class="nav-item"><a class="nav-link active text-warning" href="admin_products.php"><i class="bi bi-box-seam"></i> Quản Lý Sản Phẩm</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="admin_users.php"><i class="bi bi-people-fill"></i> Quản Lý Người Dùng</a></li>
            </ul>
            <div class="d-flex align-items-center gap-2">
                <span class="text-white small">Admin: <strong><?= htmlspecialchars($_SESSION['user']['username']) ?></strong></span>
                <a href="logout.php" class="btn btn-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Đăng Xuất</a>
            </div>
        </div>
    </div>
</nav>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Quản Lý Sản Phẩm (Quyền Admin)</h2>
            <small class="text-muted">Quản trị viên có toàn quyền xem, thêm, sửa, xóa tất cả sản phẩm</small>
        </div>
        <a href="product_add.php" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Thêm Sản Phẩm Mới
        </a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <?php if ($_GET['msg'] === 'added'): ?>
            <div class="alert alert-success alert-dismissible fade show">Thêm sản phẩm thành công! <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        <?php elseif ($_GET['msg'] === 'updated'): ?>
            <div class="alert alert-success alert-dismissible fade show">Cập nhật sản phẩm thành công! <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        <?php elseif ($_GET['msg'] === 'deleted'): ?>
            <div class="alert alert-info alert-dismissible fade show">Đã xóa sản phẩm thành công! <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 60px;">ID</th>
                            <th style="width: 90px;">Hình ảnh</th>
                            <th style="width: 110px;">Mã SP</th>
                            <th>Tên sản phẩm</th>
                            <th class="text-end" style="width: 140px;">Giá</th>
                            <th>Mô tả</th>
                            <th class="text-center" style="width: 160px;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($products)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Chưa có sản phẩm nào.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($products as $p): ?>
                                <tr>
                                    <td class="text-center fw-bold"><?= $p['id'] ?></td>
                                    <td>
                                        <img src="<?= htmlspecialchars($p['image']) ?>" 
                                             alt="<?= htmlspecialchars($p['name']) ?>" 
                                             class="rounded border" 
                                             style="width: 60px; height: 50px; object-fit: cover;"
                                             onerror="this.src='https://dummyimage.com/60x50/dee2e6/6c757d.jpg&text=No+Img'">
                                    </td>
                                    <td><span class="badge bg-secondary"><?= htmlspecialchars($p['code']) ?></span></td>
                                    <td class="fw-semibold">
                                        <a href="detail.php?id=<?= $p['id'] ?>" class="text-decoration-none text-dark">
                                            <?= htmlspecialchars($p['name']) ?>
                                        </a>
                                    </td>
                                    <td class="text-end text-danger fw-bold">
                                        <?= number_format($p['price'], 0, ',', '.') ?> đ
                                    </td>
                                    <td class="text-muted small text-truncate" style="max-width: 250px;">
                                        <?= htmlspecialchars($p['description'] ?? '') ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="detail.php?id=<?= $p['id'] ?>" class="btn btn-outline-info" title="Xem chi tiết">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="product_edit.php?id=<?= $p['id'] ?>" class="btn btn-outline-warning" title="Sửa">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="admin_products.php?action=delete&id=<?= $p['id'] ?>" 
                                               class="btn btn-outline-danger" 
                                               onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')"
                                               title="Xóa">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
