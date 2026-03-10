<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Админ вход</title>
    <style>
        body { background: #01161E; color: white; font-family: Arial; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-form { background: #021a24; padding: 40px; border-radius: 16px; border: 2px solid #2A6B84; width: 300px; }
        input { width: 100%; padding: 10px; margin: 10px 0; background: transparent; border: 2px solid #2A6B84; color: white; }
        button { width: 100%; padding: 10px; background: #AEC3B0; border: none; color: #01161E; cursor: pointer; }
    </style>
</head>
<body>
    <div class="login-form">
        <h2>Вход</h2>
        <form method="POST" action="check.php">
            <input type="text" name="login" placeholder="Логин" required>
            <input type="password" name="pass" placeholder="Пароль" required>
            <button type="submit">Войти</button>
        </form>
    </div>
</body>
</html>