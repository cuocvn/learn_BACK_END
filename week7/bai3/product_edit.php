<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/auth.php';
requireAdmin();

$db = Database::getInstance();
$id = (int)($_GET['id'] ?? 0);

$product = $db->select("SELECT * FROM products WHERE id = ?", "i", [$id]);
if (empty($product)) {
    die("<div class='container mt-5'><div class='alert alert-danger'>Không tìm thấy sản phẩm! <a href='admin_products.php'>Quay về</a></div></div>");
}
$p = $product[0];

$error = '';
$code = $p['code'];
$name = $p['name'];
$price = $p['price'];
$description = $p['description'];
$image = $p['image'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = trim($_POST['code'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $price = (float)($_POST['price'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $image = trim($_POST['image'] ?? '');

    if ($code === '' || $name === '' || $price <= 0) {
        $error = 'Vui lòng nhập đầy đủ Mã, Tên và Giá hợp lệ!';
    } else {
        $check = $db->select("SELECT id FROM products WHERE code = ? AND id != ?", "si", [$code, $id]);
        if (!empty($check)) {
            $error = 'Mã sản phẩm đã được sử dụng bởi sản phẩm khác!';
        } else {
            if ($image === '') {
                $image = 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg&text=No+Image';
            }
            $success = $db->execute(
                "UPDATE products SET code = ?, name = ?, price = ?, description = ?, image = ? WHERE id = ?",
                "ssdssi",
                [$code, $name, $price, $description, $image, $id]
            );
            if ($success) {
                header("Location: admin_products.php?msg=updated");
                exit;
            } else {
                $error = 'Không thể cập nhật sản phẩm!';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh Sửa Sản Phẩm - <?= htmlspecialchars($p['name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php"><i class="bi bi-laptop"></i> TechShop</a>
        <div class="ms-auto">
            <a href="admin_products.php" class="btn btn-warning btn-sm"><i class="bi bi-arrow-left"></i> Về Quản Lý</a>
        </div>
    </div>
</nav>

<div class="container py-5" style="max-width: 700px;">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-warning text-dark py-3">
            <h4 class="mb-0 fw-bold"><i class="bi bi-pencil-square"></i> Sửa Sản Phẩm #<?= $p['id'] ?> (Admin)</h4>
        </div>
        <div class="card-body p-4">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Mã sản phẩm <span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control" value="<?= htmlspecialchars($code) ?>" required>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-bold">Tên sản phẩm <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name) ?>" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Giá bán (VNĐ) <span class="text-danger">*</span></label>
                        <input type="number" step="1000" name="price" class="form-control" value="<?= htmlspecialchars($price) ?>" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Link hình ảnh (URL)</label>
                        <input type="text" name="image" class="form-control" value="<?= htmlspecialchars($image) ?>">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Mô tả sản phẩm</label>
                        <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($description) ?></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                    <a href="admin_products.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
                    <button type="submit" class="btn btn-warning px-4 fw-bold"><i class="bi bi-check-circle"></i> Cập Nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
