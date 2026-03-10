<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

require_once '../auth/db.php';

$error = '';
$success = '';

// Получаем ID пользователя из URL
$user_id = $_GET['id'] ?? 0;

if (!$user_id) {
    header("Location: users.php");
    exit();
}

// Получаем данные пользователя
$stmt = $pdo->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    header("Location: users.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username) || empty($email)) {
        $error = "Имя и email обязательны для заполнения!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Неверный формат email!";
    } else {
        // Проверяем, не занят ли email или username другим пользователем
        $check = $pdo->prepare("SELECT id FROM users WHERE (email = ? OR username = ?) AND id != ?");
        $check->execute([$email, $username, $user_id]);
        
        if ($check->fetch()) {
            $error = "Пользователь с таким email или именем уже существует!";
        } else {
            // Обновляем основные данные
            $update = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
            $update->execute([$username, $email, $user_id]);
            
            // Если указан новый пароль
            if (!empty($new_password)) {
                if ($new_password === $confirm_password) {
                    if (strlen($new_password) >= 6) {
                        $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                        $pass_update = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                        $pass_update->execute([$password_hash, $user_id]);
                    } else {
                        $error = "Пароль должен быть не менее 6 символов!";
                    }
                } else {
                    $error = "Новые пароли не совпадают!";
                }
            }
            
            if (empty($error)) {
                $success = "Данные пользователя успешно обновлены!";
                // Обновляем данные для отображения
                $user['username'] = $username;
                $user['email'] = $email;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ панель — Редактировать пользователя</title>
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
        
        .info-box {
            background: #12455F;
            border: 2px solid #2A6B84;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 25px;
            color: #FFE5B4;
            text-align: center;
            font-size: 16px;
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
            <h1>✏️ Редактировать пользователя</h1>
            <a href="users.php" class="back-btn">← Назад</a>
        </div>
        
        <div class="form-container">
            <div class="info-box">
                Редактирование пользователя ID: <?= $user_id ?>
            </div>
            
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
                    <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Новый пароль (оставьте пустым, если не хотите менять)</label>
                    <input type="password" name="new_password">
                </div>
                
                <div class="form-group">
                    <label>Подтверждение нового пароля</label>
                    <input type="password" name="confirm_password">
                </div>
                
                <button type="submit" class="btn">Сохранить изменения</button>
            </form>
        </div>
    </div>
</body>
</html>