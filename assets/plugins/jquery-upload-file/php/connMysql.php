<?php
header('Content-Type: text/html; charset=utf-8');
//資料庫主機設定 MAMP
$db_host     = 'localhost';
$db_username = 'root';
$db_password = '';
$db_choice   = 'npp';

$con = mysqli_connect($db_host, $db_username, $db_password, $db_choice);
// mysqli_set_charset($con, 'JSON');
mysqli_set_charset($con, 'UTF8');
// 检查连接
if (!$con) {
    die('連結錯誤: ' . mysqli_connect_error());
}
