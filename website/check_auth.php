<?php
session_start();

// Если пользователь не вошел в систему
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/index.html"); // Перенаправляем на страницу входа
    exit();
}
?>