<?php
require_once __DIR__ . '/../../config/database.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = htmlspecialchars(trim($_POST['login']), ENT_QUOTES, 'UTF-8');
    $rawPassword = trim($_POST['password']);
    
    if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/', $rawPassword)) {
        $message = 'Password must contain at least one uppercase letter, one number, and one special character.';
    } else {
        $password = password_hash($rawPassword, PASSWORD_DEFAULT);
        
        // Create database connection
        $database = new Database();
        $conn = $database->connect();

        if ($conn) {
            // Check if login already exists
            $checkSql = "SELECT id FROM utilisateur WHERE login = ?";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->bindParam(1, $login);
            $checkStmt->execute();
            
            if ($checkStmt->rowCount() > 0) {
                $message = 'Login already exists.';
            } else {
                // Insert new user
                $sql = "INSERT INTO utilisateur (login, password, date_creation) VALUES (?, ?, CURRENT_DATE())";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(1, $login);
                $stmt->bindParam(2, $password);
                
                if ($stmt->execute()) {
                    header('Location: /projet_php/public/signin/signin.php');
                    exit();
                } else {
                    $message = 'Error occurred during registration.';
                }
            }
        } else {
            $message = 'Database connection failed.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>
    <div class="container">
        <div class="form_area">
            <p class="title">SIGN UP</p>
            <?php if ($message): ?>
                <div class="error"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endif; ?>
            <form method="post" action="">
                <div class="form_group">
                    <label class="sub_title" for="login">Login</label>
                    <input type="text" class="form_style" id="login" name="login" 
                           pattern="[a-zA-Z0-9]{3,20}" 
                           title="Login must be 3-20 alphanumeric characters." 
                           placeholder="Enter your login" required>
                </div>
                <div class="form_group">
                    <label class="sub_title" for="password">Password</label>
                    <input type="password" class="form_style" id="password" name="password" 
                           minlength="6" 
                           pattern="(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}" 
                           title="Password must contain at least one uppercase letter, one number, and one special character." 
                           placeholder="Enter your password" required>
                </div>
                <div>
                    <button class="btn" type="submit">SIGN UP</button>
                    <p>Already have an Account? <a class="link" href="/projet_php/public/signin/signin.php">Sign In Here!</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
