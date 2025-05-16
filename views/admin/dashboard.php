<?php
session_start();
// Check if logged in as admin
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

require_once '../../models/Produit.php';

$productModel = new Produit();
$totalProducts = $productModel->countProducts();
$latestProducts = $productModel->getLatestProducts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/projet_php/public/style.css">
    <link rel="stylesheet" href="/projet_php/views/admin/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="admin-header">
            <h1>Admin Dashboard</h1>
            <div class="admin-info">
                Welcome, <?= htmlspecialchars($_SESSION['admin_username']) ?>
                <a href="logout.php" class="logout-button">Logout</a>
            </div>
        </div>
        
        <div class="stats-container">
            <div class="stat-card">
                <h3>Total Products</h3>
                <p><?= $totalProducts ?></p>
            </div>
            <!-- Add more stat cards here as needed -->
        </div>

    </div>
</body>
</html>
