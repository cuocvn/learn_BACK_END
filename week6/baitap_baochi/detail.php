<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'Database.php';

$db = Database::getInstance();

$id = (int)($_GET['id'] ?? 0);

$a = $db->select(
    "SELECT * FROM articles WHERE id = ?",
    "i",
    [$id]
);

if (empty($a)) {
    die("Không tìm thấy bài báo!");
}

$a = $a[0];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết bài báo - <?= htmlspecialchars($a['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">

    <h2>Chi tiết bài báo</h2>

    <div class="card p-4 mt-3 shadow-sm">
        <!-- Mã và Tiêu đề bài báo -->
        <h3 class="text-primary fw-bold">
            <?= htmlspecialchars($a['title']) ?>
        </h3>

        <!-- Tác giả -->
        <p class="text-muted">
            Mã bài viết: #<?= $a['id'] ?> | Tác giả: <strong class="text-dark"><?= htmlspecialchars($a['author']) ?></strong>
        </p>
        <hr>

        <!-- Nội dung đầy đủ (Full) -->
        <p class="fs-5" style="line-height: 1.8;">
            <?= nl2br(htmlspecialchars($a['content'] ?? '')) ?>
        </p>

        <!-- Nút quay về -->
        <div class="mt-4">
            <a href="danhsachbaibao.php" class="btn btn-primary">
                Quay lại
            </a>
        </div>
    </div>

</body>
</html>