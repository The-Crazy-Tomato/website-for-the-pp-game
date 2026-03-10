<?php
session_start();
require_once '../auth/db.php';

// Разрешаем запросы с любого источника (для AJAX)
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Получаем данные из запроса
$message = $_POST['message'] ?? '';

if (empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Пустое сообщение']);
    exit();
}

// Определяем пользователя (если авторизован)
$user_id = $_SESSION['user_id'] ?? null;
$username = $_SESSION['username'] ?? null;
$email = $_SESSION['email'] ?? null;

try {
    // Сохраняем в базу данных
    $stmt = $pdo->prepare("INSERT INTO support_messages (user_id, username, email, message) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $username, $email, $message]);
    
    echo json_encode(['success' => true, 'message' => 'Сообщение отправлено']);
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Ошибка базы данных: ' . $e->getMessage()]);
}
?>