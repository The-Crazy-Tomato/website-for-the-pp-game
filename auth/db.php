<?php
$host = 'localhost';
$db   = 'zenatu9e_my_webs';
$user = 'zenatu9e_my_webs';
$pass = 'Dsv674w_Dg4lk3';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $opt);
} catch (\PDOException $e) {
    die("Ошибка подключения к БД: " . $e->getMessage());
}
?>