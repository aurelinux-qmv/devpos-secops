<?php
// Cung cấp thông tin kết nối database thủ công để đơn giản hóa.
$db_host      = 'mysql-devops-doan-19613.mysql.database.azure.com';
$db_database  = 'flexibleserverdb';
$db_username  = 'qvoadmin';
$db_password  = 'tdc@123';

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
