<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Простая валидация
    if (empty($username) || empty($email) || empty($password)) {
        die("Заполните все поля!");
    }

    if ($password !== $password_confirm) {
        die("Пароли не совпадают!");
    }

    // Хэшируем пароль
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Подготавливаем запрос
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
    
    try {
        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $password_hash
        ]);
        
        // Вместо вывода сообщения, делаем редирект на страницу входа с параметром успеха
        header("Location: index.html?success=registered");
        exit();
        
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "Такой Email уже зарегистрирован!";
        } else {
            echo "Ошибка: " . $e->getMessage();
        }
    }
}
?>