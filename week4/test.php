<?php
$hoTen = "Dinh Hoang Cuoc";

$tu = explode(" ", $hoTen);

$gmail = "";

for ($i = 0; $i < count($tu) - 1; $i++) {
    $gmail .= $tu[$i][0];
}

$gmail .= $tu[count($tu) - 1];

$gmail = strtolower($gmail) . "@gmail.com";

echo $gmail;
?>
