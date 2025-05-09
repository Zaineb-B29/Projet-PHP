<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/User.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = htmlspecialchars(trim($_POST['login']), ENT_QUOTES, 'UTF-8');
    $rawPassword = trim($_POST['password']);
    if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/', $rawPassword)) {
        $message = 'Password must contain at least one uppercase letter, one number, and one special character.';
    } else {
        $password = password_hash($rawPassword, PASSWORD_DEFAULT);
    }

    if (!empty($login) && !empty($password)) {
        $user = new User();
        if ($user->create($login, $password)) {
            header('Location: login.php');
            exit();
        } else {
            $message = 'Login already exists or error occurred.';
        }
    } else {
        $message = 'All fields are required.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    <?php include __DIR__ . '/../../views/templates/header.html'; ?>

<div class="container mt-5">
    <h2>Sign Up</h2>
    <?php if ($message): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>
    <form method="post" action="">
        <div class="mb-3">
            <label class="form-label">Login</label>
            <input type="text" class="form-control" name="login" pattern="[a-zA-Z0-9]{3,20}" title="Login must be 3-20 alphanumeric characters." required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password (min. 6 characters)</label>
            <input type="password" class="form-control" name="password" minlength="6" pattern="(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}" title="Password must contain at least one uppercase letter, one number, and one special character." required>
        </div>
        <button type="submit" class="btn btn-primary">Sign Up</button>
    </form>
</div>

<?php include __DIR__ . '/../../views/templates/footer.html'; ?>
</body>
</html>
