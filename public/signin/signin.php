<?php
// Include header
require_once __DIR__ . '/../../includes/header.html';

// Include database connection
require_once __DIR__ . '/../../config/database.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate inputs
    if (!empty($name) && !empty($email) && !empty($password)) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert into database
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $hashedPassword);

        if ($stmt->execute()) {
            echo "Sign-up successful!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "All fields are required!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="signin.css"> <!-- Update with your CSS file path -->
</head>
<body>
    <!-- From Uiverse.io by mi-series -->
    <div class="container">
        <div class="form_area">
            <p class="title">SIGN UP</p>
            <form action="" method="POST">
                <div class="form_group">
                    <label class="sub_title" for="name">Name</label>
                    <input placeholder="Enter your full name" class="form_style" type="text" id="name" name="name" required>
                </div>
                <div class="form_group">
                    <label class="sub_title" for="email">Email</label>
                    <input placeholder="Enter your email" id="email" class="form_style" type="email" name="email" required>
                </div>
                <div class="form_group">
                    <label class="sub_title" for="password">Password</label>
                    <input placeholder="Enter your password" id="password" class="form_style" type="password" name="password" required>
                </div>
                <div>
                    <button class="btn" type="submit">SIGN UP</button>
                    <p>Have an Account? <a class="link" href="../signup/singup.php">Sign Up Here!</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>