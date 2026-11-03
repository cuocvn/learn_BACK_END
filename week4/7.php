<form method="post">

    <input type="text" name="tu1">
    <input type="text" name="tu2">
    <input type="text" name="tu3">
    <input type="text" name="tu4">

    <button type="submit">Submit</button>

</form>

<?php
$mang = [
    $_POST['tu1'] ?? "",
    $_POST['tu2'] ?? "",
    $_POST['tu3'] ?? "",
    $_POST['tu4'] ?? ""
];

foreach ($mang as $i => $value) {
    echo ($i + 1) . " - " . ucfirst($value) . " Product<br>";
}
?>