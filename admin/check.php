<?php
session_start();
require_once '../auth/db.php';

$login = $_POST['login'] ?? '';
$pass = $_POST['pass'] ?? '';

// Простая проверка
if ($login === 'admin' && $pass === 'admin123') {
    $_SESSION['admin'] = true;
    header("Location: panel.php");
    exit();
} else {
    header("Location: login.php?error=1");
    exit();
}
?>