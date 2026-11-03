<?php
require_once __DIR__ . '/Database.php';

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
    <title>Quản Lý Sản Phẩm - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php"><i class="bi bi-shop"></i> MiniShop</a>
        <div class="ms-auto">
            <a href="index.php" class="btn btn-outline-light me-2">Trang Chủ</a>
            <a href="admin_products.php" class="btn btn-warning active"><i class="bi bi-gear-fill"></i> Quản Lý Sản Phẩm</a>
        </div>
    </div>
</nav>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Quản Lý Sản Phẩm</h2>
            <small class="text-muted">Danh sách, thêm, xóa và sửa sản phẩm</small>
        </div>
        <a href="product_add.php" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Thêm Sản Phẩm Mới
        </a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <?php if ($_GET['msg'] === 'added'): ?>
            <div class="alert alert-success alert-dismissible fade show">Thêm sản phẩm mới thành công! <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
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
                            <th style="width: 100px;">Hình ảnh</th>
                            <th style="width: 110px;">Mã SP</th>
                            <th>Tên sản phẩm</th>
                            <th class="text-end" style="width: 130px;">Giá</th>
                            <th>Mô tả</th>
                            <th class="text-center" style="width: 170px;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($products)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Chưa có sản phẩm nào trong CSDL.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($products as $p): ?>
                                <tr>
                                    <td class="text-center fw-bold"><?= $p['id'] ?></td>
                                    <td>
                                        <img src="<?= htmlspecialchars($p['image']) ?>" 
                                             alt="<?= htmlspecialchars($p['name']) ?>" 
                                             class="rounded border" 
                                             style="width: 65px; height: 50px; object-fit: cover;"
                                             onerror="this.src='https://dummyimage.com/65x50/dee2e6/6c757d.jpg&text=No+Img'">
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
