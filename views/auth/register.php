<?php
require_once '../../controllers/AuthController.php';
$controller = new AuthController();
$controller->register();
include '../templates/header.php';
?>
<h2>Register</h2>
<form method="post">
    <input name="login" placeholder="Login" class="form-control mb-2">
    <input name="password" type="password" placeholder="Password" class="form-control mb-2">
    <button class="btn btn-success">Register</button>
</form>
<?php include '../templates/footer.php'; ?>
