<?php
// model/Category.php
require_once __DIR__ . '/db.php';

class Category {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    // Lấy tất cả danh mục
    public function getAllCategory() {
        $sql = "SELECT * FROM categories";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}