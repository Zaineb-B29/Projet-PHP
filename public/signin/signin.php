<?php
// Include database connection
require_once __DIR__ . '/../../config/database.php';

// Create database connection
$database = new Database();
$conn = $database->connect();

// Check connection
if (!$conn) {
    die("Connection failed: Unable to connect to database");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);

    // Validate inputs
    if (!empty($login) && !empty($password)) {
        // Check user credentials
        $sql = "SELECT id, login, password FROM utilisateur WHERE login = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $login);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            if (password_verify($password, $result['password'])) {
                // Start session and store user data
                session_start();
                $_SESSION['user_id'] = $result['id'];
                $_SESSION['user_login'] = $result['login'];
                
                // Redirect to home page
                header("Location: /projet_php/public/index.php");
                exit();
            } else {
                $error = "Invalid password";
            }
        } else {
            $error = "User not found";
        }
    } else {
        $error = "All fields are required";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/projet_php/public/style.css">
    <link rel="stylesheet" href="signin.css">
</head>
<body>
    <div class="white-container">
        <?php
        include_once(__DIR__ . '/../../views/templates/header/header.php');
        ?>
    </div>

    <div class="container">
        <div class="form_area">
            <p class="title">SIGN IN</p>
            <?php if (isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            <form action="" method="POST">
                <div class="form_group">
                    <label class="sub_title" for="login">Login</label>
                    <input placeholder="Enter your login" id="login" class="form_style" type="text" name="login" required>
                </div>
                <div class="form_group">
                    <label class="sub_title" for="password">Password</label>
                    <input placeholder="Enter your password" id="password" class="form_style" type="password" name="password" required>
                </div>
                <div>
                    <button class="btn" type="submit">SIGN IN</button>
                    <p>Don't have an Account? <a class="link" href="/projet_php/public/signup/signup.php">Sign Up Here!</a></p>
                </div>
            </form>
        </div>
    </div>

    <div class="white-container">
        <?php
        include_once(__DIR__ . '/../../views/templates/footer/footer.php');
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>