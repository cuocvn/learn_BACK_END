<?php
//model/Product.php

require_once __DIR__ .'/db.php';

class Product{

private $conn;

public function __construct()
{
    global $conn;
    $this->conn=$conn;//lay lien ket tu db.hph
 }
    // 1. Lấy tất cả sản phẩm kèm tên danh mục
    public function getAllProduct($limit = null) {
        $sql = "SELECT p.*, GROUP_CONCAT(c.name SEPARATOR ', ') AS category_names 
                FROM products p 
                LEFT JOIN product_categories pc ON p.id = pc.product_id 
                LEFT JOIN categories c ON pc.category_id = c.id 
                GROUP BY p.id 
                ORDER BY p.id DESC";
        if ($limit) {
            $sql .= " LIMIT " . (int)$limit;
        }
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
      // 2. Lấy chi tiết 1 sản phẩm theo ID (kèm tên các danh mục)
    public function getProductById($id) {
        $sql = "SELECT p.*, GROUP_CONCAT(c.name SEPARATOR ', ') AS category_names 
                FROM products p 
                LEFT JOIN product_categories pc ON p.id = pc.product_id 
                LEFT JOIN categories c ON pc.category_id = c.id 
                WHERE p.id = ?
                GROUP BY p.id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
  // 3. Lấy sản phẩm theo danh mục (qua bảng trung gian product_categories)
    public function getProductByCateId($cateId) {
        $sql = "SELECT p.* FROM products p 
                JOIN product_categories pc ON p.id = pc.product_id 
                WHERE pc.category_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$cateId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // 4. Thêm sản phẩm mới
    public function add($name, $price, $image, $description, $stock = 0) {
        $sql = "INSERT INTO products (name, price, image, description, stock) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$name, $price, $image, $description, $stock]);
    }
    // 5. Sửa thông tin sản phẩm
    public function edit($id, $name, $price, $image, $description, $stock) {
        $sql = "UPDATE products 
                SET name = ?, price = ?, image = ?, description = ?, stock = ? 
                WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$name, $price, $image, $description, $stock, $id]);
    }
    // 6. Xóa sản phẩm
    public function delete($id) {
        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>