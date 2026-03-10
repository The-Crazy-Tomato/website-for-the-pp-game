<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

require_once '../auth/db.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if (empty($username) || empty($email) || empty($password)) {
        $error = "Заполните все поля!";
    } elseif ($password !== $password_confirm) {
        $error = "Пароли не совпадают!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Неверный формат email!";
    } elseif (strlen($password) < 6) {
        $error = "Пароль должен быть не менее 6 символов!";
    } else {
        // Проверяем, существует ли пользователь
        $check = $pdo->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
        $check->execute([$email, $username]);
        
        if ($check->fetch()) {
            $error = "Пользователь с таким email или именем уже существует!";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $password_hash]);
            
            $success = "Пользователь успешно добавлен!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ панель — Добавить пользователя</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background-color: #01161E;
            color: #FFFFFF;
            font-family: 'Uncial Antiqua', serif;
            padding: 40px;
        }
        
        .admin-container {
            max-width: 600px;
            margin: 0 auto;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding: 20px;
            background: #021a24;
            border: 2px solid #2A6B84;
            border-radius: 12px;
        }
        
        .header h1 {
            color: #AEC3B0;
            font-size: 28px;
        }
        
        .back-btn {
            padding: 8px 16px;
            background: transparent;
            border: 2px solid #2A6B84;
            border-radius: 40px;
            color: #AEC3B0;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .back-btn:hover {
            background: #2A6B84;
            color: white;
        }
        
        .form-container {
            background: #021a24;
            border: 2px solid #2A6B84;
            border-radius: 16px;
            padding: 40px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            color: #FFE5B4;
            margin-bottom: 8px;
            font-size: 16px;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            background: transparent;
            border: 2px solid #2A6B84;
            border-radius: 8px;
            color: #FFFFFF;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        .form-group input:focus {
            border-color: #AEC3B0;
            outline: none;
        }
        
        .btn {
            width: 100%;
            padding: 14px;
            background: transparent;
            border: 2px solid #AEC3B0;
            border-radius: 40px;
            color: #AEC3B0;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }
        
        .btn:hover {
            background: #AEC3B0;
            color: #01161E;
        }
        
        .error-message {
            background: rgba(255, 107, 107, 0.2);
            border: 2px solid #ff6b6b;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 20px;
            color: #ff6b6b;
            text-align: center;
        }
        
        .success-message {
            background: rgba(76, 175, 80, 0.2);
            border: 2px solid #4CAF50;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 20px;
            color: #4CAF50;
            text-align: center;
        }
        
        @media (max-width: 768px) {
            body { padding: 20px; }
            .header { flex-direction: column; gap: 15px; }
            .header h1 { font-size: 24px; }
            .form-container { padding: 25px; }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="header">
            <h1>➕ Добавить пользователя</h1>
            <a href="users.php" class="back-btn">← Назад</a>
        </div>
        
        <div class="form-container">
            <?php if ($error): ?>
                <div class="error-message"><?= $error ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="success-message"><?= $success ?></div>
                <script>
                    setTimeout(() => {
                        window.location.href = 'users.php';
                    }, 2000);
                </script>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label>Имя пользователя</label>
                    <input type="text" name="username" required>
                </div>
                
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label>Пароль (минимум 6 символов)</label>
                    <input type="password" name="password" required minlength="6">
                </div>
                
                <div class="form-group">
                    <label>Подтверждение пароля</label>
                    <input type="password" name="password_confirm" required>
                </div>
                
                <button type="submit" class="btn">Создать пользователя</button>
            </form>
        </div>
    </div>
</body>
</html>