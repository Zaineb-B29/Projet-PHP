<?php
session_start();
require_once '../../models/Admin.php';

// Check if already logged in as admin
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin = new Admin();
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($admin->login($username, $password)) {
        $_SESSION['admin_id'] = $admin->id;
        $_SESSION['admin_username'] = $admin->username;
        header('Location: dashboard.php');
        exit();
    } else {
        $error = 'Invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="/projet_php/public/style.css">
    <link rel="stylesheet" href="/projet_php/views/admin/dashboard.css">
    <style>
        .admin-login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .admin-login-container h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .admin-login-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .form-group label {
            color: #666;
            font-size: 0.9rem;
        }

        .form-group input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        .form-group input:focus {
            outline: none;
            border-color: #007bff;
        }

        .error-message {
            color: #ff4444;
            text-align: center;
            margin-bottom: 20px;
        }

        .login-button {
            background: #007bff;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .login-button:hover {
            background: #0056b3;
        }

        .back-to-site {
            text-align: center;
            margin-top: 20px;
        }

        .back-to-site a {
            color: #666;
            text-decoration: none;
        }

        .back-to-site a:hover {
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="admin-login-container">
        <h1>Admin Login</h1>
        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form class="admin-login-form" method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="login-button">Login</button>
        </form>
        
        <div class="back-to-site">
            <a href="/projet_php/public/index.php">← Back to Main Site</a>
        </div>
    </div>
</body>
</html> 