<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn() {
    return isset($_SESSION['user']);
}

function isAdmin() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit;
    }
}

function requireAdmin() {
    if (!isAdmin()) {
        die("<div style='font-family: sans-serif; text-align: center; margin-top: 50px;'>
                <h2 style='color: red;'>Truy cập bị từ chối!</h2>
                <p>Bạn không có quyền quản trị viên (Admin) để truy cập trang này.</p>
                <a href='index.php'>Quay về trang chủ</a>
             </div>");
    }
}
?>