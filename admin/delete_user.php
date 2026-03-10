<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

require_once '../auth/db.php';

$user_id = $_GET['id'] ?? 0;

if ($user_id) {
    // Удаляем пользователя
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
}

header("Location: users.php?deleted=1");
exit();
?>