<?php
define('HOST', 'localhost');
define('DATABASE', 'student');
define('USER', 'localview');
define('PASSWORD', 'dblocalview');

try {
    $dbconn = new PDO("mysql:host=" . HOST . ";dbname=" . DATABASE . ";charset=utf8mb4", USER, PASSWORD);
    $dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}