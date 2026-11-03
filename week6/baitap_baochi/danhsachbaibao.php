<?php
require_once __DIR__ . '/Database.php';

// Kết nối Database
$db = Database::getInstance();

// Lấy danh sách bài báo (xếp từ mới nhất hoặc theo thứ tự)
$sql = "SELECT * FROM articles ORDER BY id DESC";
$articles = $db->select($sql);

// Hàm cắt đúng số từ (mặc định 50 từ), giữ nguyên vẹn từ chứ không cắt giữa chữ
function catMoTa50Tu($text, $limit = 50) {
    $text = trim($text);
    // Tách chuỗi thành mảng các từ dựa trên khoảng trắng
    $words = preg_split('/\s+/u', $text);
    
    // Nếu tổng số từ nhiều hơn 50 thì lấy đúng 50 từ đầu tiên ghép lại
    if (count($words) > $limit) {
        return implode(' ', array_slice($words, 0, $limit)) . '...';
    }
    return $text;
}
?>

<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Trang Tin Tức Báo Chí</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand fw-bold" href="danhsachbaibao.php">Báo Chí 24h</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" href="danhsachbaibao.php">Trang chủ</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">Giới thiệu</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Header-->
        <header class="bg-primary py-5">
            <div class="container px-4 px-lg-5 my-4">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Tin Tức Mỗi Ngày</h1>
                    <p class="lead fw-normal text-white-50 mb-0">Cập nhật tin tức nhanh chóng và chính xác</p>
                </div>
            </div>
        </header>

        <!-- Section: Các bài báo xếp từ trên xuống -->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-3">
                <div class="row justify-content-center">
                    <?php foreach ($articles as $a): ?>
                        <!-- Dùng col-12 để mỗi bài báo nằm trên 1 hàng, xếp dọc từ trên xuống -->
                        <div class="col-12 col-md-10 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-body p-4">
                                    <!-- Tiêu đề bài báo -->
                                    <h4 class="fw-bolder text-primary">
                                        <?= htmlspecialchars($a['title']) ?>
                                    </h4>
                                    
                                    <!-- Tác giả -->
                                    <p class="text-muted small mb-2">
                                        Tác giả: <strong><?= htmlspecialchars($a['author']) ?></strong>
                                    </p>

                                    <!-- Mô tả 50 từ (không cắt ngang chữ) -->
                                    <p class="card-text">
                                        <?= htmlspecialchars(catMoTa50Tu($a['content'], 50)) ?>
                                    </p>

                                    <!-- Nút xem chi tiết -->
                                    <div class="mt-3">
                                        <a class="btn btn-outline-dark" href="detail.php?id=<?= $a['id'] ?>">
                                            Xem chi tiết
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Footer-->
        <footer class="py-4 bg-dark">
            <div class="container">
                <p class="m-0 text-center text-white">Copyright &copy; Web Báo Chí 2026</p>
            </div>
        </footer>
    </body>
</html>