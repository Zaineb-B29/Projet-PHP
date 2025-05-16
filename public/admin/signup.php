<?php
session_start();
require_once '../../models/Admin.php';

// Check if already logged in as admin
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin = new Admin();
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } else {
        if ($admin->register($username, $password)) {
            $success = 'Registration successful! You can now login.';
        } else {
            $error = 'Username already exists or registration failed';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sign Up</title>
    <link rel="stylesheet" href="/projet_php/public/style.css">
    <style>
        .admin-signup-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .admin-signup-container h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .admin-signup-form {
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
            border-color: #28a745;
        }

        .error-message {
            color: #dc3545;
            text-align: center;
            margin-bottom: 20px;
        }

        .success-message {
            color: #28a745;
            text-align: center;
            margin-bottom: 20px;
        }

        .signup-button {
            background: #28a745;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .signup-button:hover {
            background: #218838;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: #28a745;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
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
            color: #28a745;
        }
    </style>
</head>
<body>
    <div class="admin-signup-container">
        <h1>Admin Sign Up</h1>
        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success-message"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        
        <form class="admin-signup-form" method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit" class="signup-button">Sign Up</button>
        </form>
        
        <div class="login-link">
            Already have an account? <a href="login.php">Login here</a>
        </div>

        <div class="back-to-site">
            <a href="/projet_php/public/index.php">← Back to Main Site</a>
        </div>
    </div>
</body>
</html> 