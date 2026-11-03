<?php
require_once "Database.php";

$db = Database::getInstance();

$sql = "SELECT * FROM products ORDER BY price DESC";
$products = $db->select($sql);

echo "<h3>Danh sách sản phẩm:</h3>";

foreach ($products as $p) {
    echo "{$p['id']}. {$p['name']} - Giá: {$p['price']} VND<br>";
}

$db->close();
?>

<h1>hi</h1>