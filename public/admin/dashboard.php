<?php
session_start();
// Check if logged in as admin
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

require_once '../../models/Produit.php';
require_once '../../models/User.php';

$productModel = new Produit();
$userModel = new User();
$totalProducts = $productModel->countProducts();
$totalUsers = $userModel->countUsers();
$totalAdmins = $userModel->countAdmins();
$latestProducts = $productModel->getLatestProducts(5);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/projet_php/public/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .dashboard-layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            padding: 20px 0;
        }

        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid #34495e;
        }

        .sidebar-header h2 {
            margin: 0;
            font-size: 1.5rem;
        }

        .admin-info {
            margin-top: 10px;
            font-size: 0.9rem;
            color: #bdc3c7;
        }

        .menu-list {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }

        .menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            color: #ecf0f1;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .menu-item:hover {
            background-color: #34495e;
        }

        .menu-item.active {
            background-color: #3498db;
        }

        .menu-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            background-color: #f5f6fa;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }

        .stats-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-box {
            flex: 1;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #2c3e50;
            margin: 10px 0;
        }

        .stat-label {
            color: #7f8c8d;
            font-size: 1rem;
        }

        .products-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 30px;
        }

        .product-list {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .product-list h2 {
            margin: 0 0 20px 0;
            color: #333;
            font-size: 1.5rem;
        }

        .logout-button {
            padding: 8px 16px;
            background-color: #e74c3c;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .logout-button:hover {
            background-color: #c0392b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            .dashboard-layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .stats-container {
                flex-direction: column;
            }

            .products-section {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-layout">
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Panel</h2>
                <div class="admin-info">
                    Welcome, <?= htmlspecialchars($_SESSION['admin_username']) ?>
                </div>
            </div>
            
            <ul class="menu-list">
                <li>
                    <a href="dashboard.php" class="menu-item active">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="products.php" class="menu-item">
                        <i class="fas fa-box"></i>
                        Products
                    </a>
                </li>
                <li>
                    <a href="users.php" class="menu-item">
                        <i class="fas fa-users"></i>
                        Users
                    </a>
                </li>
                <li>
                    <a href="admins.php" class="menu-item">
                        <i class="fas fa-user-shield"></i>
                        Admins
                    </a>
                </li>
            </ul>
        </div>

        <div class="main-content">
            <div class="dashboard-header">
                <h1>Dashboard Overview</h1>
                <a href="logout.php" class="logout-button">Logout</a>
            </div>

            <div class="stats-container">
                <div class="stat-box">
                    <div class="stat-number"><?= $totalProducts ?></div>
                    <div class="stat-label">Products</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number"><?= $totalUsers ?></div>
                    <div class="stat-label">Users</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number"><?= $totalAdmins ?></div>
                    <div class="stat-label">Admins</div>
                </div>
            </div>

            
        </div>
    </div>
</body>
</html> 