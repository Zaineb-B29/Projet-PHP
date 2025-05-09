
<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../auth/login.php');
    exit();
}
require_once '../../models/User.php';
require_once '../../models/Product.php';

$userModel = new User();
$productModel = new Product();
include '../templates/header.php';
?>
<h2>Admin Dashboard</h2>
<ul>
    <li>Total Users: <?= $userModel->countUsers(); ?></li>
    <li>Total Products: <?= $productModel->countProducts(); ?></li>
</ul>
<?php include '../templates/footer.php'; ?>
