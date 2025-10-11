<?php
// Lấy thông tin từ biến môi trường do Docker Compose cung cấp.
// Toán tử '??' sẽ gán giá trị mặc định nếu biến môi trường không tồn tại.
$db_host     = 'db';
$db_database = 'computer_store';
$db_username = 'root';
$db_password = 'admin';

// Cập nhật mảng config
$configDB = array();
$configDB["host"]       = $db_host;
$configDB["database"]   = $db_database;
$configDB["username"]   = $db_username;
$configDB["password"]   = $db_password;

// Cập nhật các hằng số
define("HOST", $db_host);
define("DB_NAME", $db_database);
define("DB_USER", $db_username);
define("DB_PASS", $db_password);

define('ROOT', dirname(dirname(__FILE__)));
//Thu muc tuyet doi truoc cua config; c:/wamp/www/lab/
define("BASE_URL", "http://" . $_SERVER['SERVER_NAME']); //dia chi website
?>
