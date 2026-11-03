<?php
require_once "Database.php";

$db = Database::getInstance();

$sql = "SELECT * FROM articles ORDER BY id DESC";
$articles = $db->select($sql);

echo "<h3>Danh sách bài báo:</h3>";

foreach ($articles as $a) {
    echo "{$a['id']}. {$a['title']} - Tác giả: {$a['author']}<br>";
}

$db->close();
?>