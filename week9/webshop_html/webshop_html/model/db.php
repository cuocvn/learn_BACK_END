<?php
$host='localhost';
$dbname='shop_db';
$user='root';
$pass='';

try{
$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass );
//baop loi ra man hinh neu sai cau lenh
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


}catch (PDOException $e){
    die("Loi ket noi: ".$e->getMessage());
}
?>