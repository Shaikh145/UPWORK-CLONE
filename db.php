<?php
$host = 'localhost';
$db = 'dbozfkn1igdvne';
$user = 'uklz9ew3hrop3';
$pass = 'zyrbspyjlzjb';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
