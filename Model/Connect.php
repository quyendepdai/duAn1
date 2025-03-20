<?php
$host = 'localhost';
$db_name = 'du an 1';
$db_user = 'root';
$db_pass = '';
try {
    $conn = new PDO("mysql: host=$host; dbname=$db_name", $db_user, $db_pass);
    // echo 'Kết nối thành công';
} catch (Exception $e) {
    echo ' kết nối không thành công' . $e->getMessage();
}
