<?php
// Lấy thông tin kết nối từ các biến môi trường do Kubernetes cung cấp.
// Đây là cách làm chuẩn trong môi trường container.
$db_host      = getenv('DB_HOST');
$db_database  = getenv('DB_NAME');
$db_username  = getenv('DB_USER');
$db_password  = getenv('DB_PASS'); // Sửa lại để khớp với file deployment

// Cập nhật mảng config
$configDB = array();
$configDB["host"]        = $db_host;
$configDB["database"]    = $db_database;
$configDB["username"]    = $db_username;
$configDB["password"]    = $db_password;

// Cập nhật các hằng số
define("HOST", $db_host);
define("DB_NAME", $db_database);
define("DB_USER", $db_username);
define("DB_PASS", $db_password);

define('ROOT', dirname(dirname(__FILE__)));
// Thu muc tuyet doi truoc cua config; c:/wamp/www/lab/
define("BASE_URL", "http://" . $_SERVER['SERVER_NAME']); // dia chi website
?>
