<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            $user = $userModel->login($_POST['login'], $_POST['password']);
            if ($user) {
                session_start();
                $_SESSION['user'] = $user;
                header('Location: /views/admin/dashboard.php');
                exit();
            } else {
                echo "<div class='alert alert-danger'>Login failed.</div>";
            }
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            if ($userModel->register($_POST['login'], $_POST['password'])) {
                header('Location: /views/auth/login.php');
                exit();
            } else {
                echo "<div class='alert alert-danger'>Registration failed.</div>";
            }
        }
    }
}
