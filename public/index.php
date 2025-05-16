<?php require_once __DIR__ . '/../config/database.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Store</title>
    <link rel="stylesheet" href="/projet_php/public/style.css">
    <style>
        .landing-container {
            max-width: 800px;
            margin: 100px auto;
            text-align: center;
            padding: 20px;
        }

        .welcome-title {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 40px;
        }

        .interface-links {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 40px;
        }

        .interface-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            width: 300px;
            transition: transform 0.3s ease;
        }

        .interface-card:hover {
            transform: translateY(-5px);
        }

        .interface-card h2 {
            color: #333;
            margin-bottom: 15px;
        }

        .interface-card p {
            color: #666;
            margin-bottom: 20px;
        }

        .interface-link {
            display: inline-block;
            padding: 12px 24px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .interface-link:hover {
            background-color: #0056b3;
        }

        .admin-link {
            background-color: #28a745;
        }

        .admin-link:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="landing-container">
        <h1 class="welcome-title">Welcome to Our Store</h1>
        
        <div class="interface-links">
            <div class="interface-card">
                <h2>User Interface</h2>
                <p>Browse products, make purchases, and manage your account</p>
                <a href="/projet_php/public/user/index.php" class="interface-link">Go to User Interface</a>
            </div>
            
            <div class="interface-card">
                <h2>Admin Interface</h2>
                <p>Manage products, view statistics, and handle store operations</p>
                <a href="/projet_php/public/admin/login.php" class="interface-link admin-link">Go to Admin Interface</a>
            </div>
        </div>
    </div>
</body>
</html>