<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../auth/index.html");
    exit();
}

require_once '../auth/db.php';

$user_id = $_SESSION['user_id'];

// Получаем данные пользователя
$stmt = $pdo->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Обработка обновления профиля
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = trim($_POST['username']);
    $new_email = trim($_POST['email']);
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Проверяем текущий пароль
    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user_data = $stmt->fetch();
    
    if (!password_verify($current_password, $user_data['password'])) {
        $error = "Неверный текущий пароль!";
    } else {
        // Обновляем основные данные
        $update_stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
        $update_stmt->execute([$new_username, $new_email, $user_id]);
        
        // Если указан новый пароль
        if (!empty($new_password)) {
            if ($new_password === $confirm_password) {
                $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                $pass_stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                $pass_stmt->execute([$password_hash, $user_id]);
            } else {
                $error = "Новые пароли не совпадают!";
            }
        }
        
        if (!isset($error)) {
            $_SESSION['username'] = $new_username;
            $success = "Профиль успешно обновлён!";
            // Обновляем данные пользователя
            $user['username'] = $new_username;
            $user['email'] = $new_email;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль — Pocket World</title>
    <link rel="stylesheet" href="../Untitled.css">
    <style>
        .profile-container {
            max-width: 600px;
            margin: 120px auto 60px;
            padding: 40px;
            background: #021a24;
            border: 2px solid #2A6B84;
            border-radius: 16px;
        }
        
        .profile-title {
            font-size: 36px;
            color: #AEC3B0;
            margin-bottom: 30px;
            text-align: center;
            font-family: 'Sjz', cursive;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            color: #FFE5B4;
            margin-bottom: 8px;
            font-size: 18px;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px;
            background: transparent;
            border: 2px solid #2A6B84;
            border-radius: 8px;
            color: #FFFFFF;
            font-size: 16px;
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
        
        .btn-danger {
            border-color: #ff6b6b;
            color: #ff6b6b;
        }
        
        .btn-danger:hover {
            background: #ff6b6b;
            color: #01161E;
        }
        
        .success-message {
            background: rgba(76, 175, 80, 0.2);
            border: 2px solid #4CAF50;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            color: #4CAF50;
            text-align: center;
        }
        
        .error-message {
            background: rgba(255, 107, 107, 0.2);
            border: 2px solid #ff6b6b;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            color: #ff6b6b;
            text-align: center;
        }
        
        .section-divider {
            height: 2px;
            background: #2A6B84;
            margin: 30px 0;
        }
        
        .back-link {
            display: inline-block;
            color: #AEC3B0;
            text-decoration: none;
            margin-bottom: 20px;
            font-size: 18px;
        }
        
        .back-link:hover {
            color: #FFE5B4;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <a href="../index.html" class="back-link">← На главную</a>
        <h1 class="profile-title">Профиль пользователя</h1>
        
        <?php if (isset($success)): ?>
            <div class="success-message"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Имя пользователя</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            
            <div class="section-divider"></div>
            
            <div class="form-group">
                <label>Текущий пароль (обязательно)</label>
                <input type="password" name="current_password" required>
            </div>
            
            <div class="form-group">
                <label>Новый пароль (оставьте пустым, если не хотите менять)</label>
                <input type="password" name="new_password">
            </div>
            
            <div class="form-group">
                <label>Подтвердите новый пароль</label>
                <input type="password" name="confirm_password">
            </div>
            
            <button type="submit" class="btn">Сохранить изменения</button>
        </form>
        
        <div class="section-divider"></div>
        
        <!-- Кнопка удаления аккаунта -->
        <form method="POST" action="delete_account.php" onsubmit="return confirm('Вы уверены? Это действие нельзя отменить!');">
            <button type="submit" class="btn btn-danger">Удалить аккаунт</button>
        </form>
    </div>
</body>
</html>