
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'Database.php';

$db = Database::getInstance();

$id = (int)($_GET['id'] ?? 0);

$p = $db->select(
    "SELECT * FROM products WHERE id = ?",
    "i",
    [$id]
);

if (empty($p)) {
    die("Không tìm thấy sản phẩm!");
}

$p = $p[0];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Chi tiết sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">

    <h2>Chi tiết sản phẩm</h2>

    <div class="card p-4 mt-3">

        <h3><?= htmlspecialchars($p['name']) ?></h3>

        <h4 class="text-danger">
            <?= number_format($p['price']) ?> VNĐ
        </h4>

        <p>
            Mô tả: <?= htmlspecialchars($p['description'] ?? '') ?>
        </p>

        <a href="danhsachsanpham.php" class="btn btn-primary">
            Quay lại
        </a>

    </div>

</body>
</html>
