<?php
require_once __DIR__ . '/../config/database.php';

class User {
    private $conn;
    private $table = 'utilisateur';

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function register($login, $password) {
        $stmt = $this->conn->prepare("INSERT INTO $this->table (login, password, date_creation) VALUES (?, ?, ?)");
        return $stmt->execute([$login, $password, date('Y-m-d')]);
    }

    public function login($login, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE login = ? AND password = ?");
        $stmt->execute([$login, $password]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function countUsers() {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM $this->table");
        return $stmt->fetchColumn();
    }
    public function create($login, $password) {
    $pdo = (new Database())->connect();

    // Check if user already exists
    $checkStmt = $pdo->prepare("SELECT * FROM utilisateur WHERE login = ?");
    $checkStmt->execute([$login]);
    if ($checkStmt->rowCount() > 0) {
        return false;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO utilisateur (login, password, date_creation) VALUES (?, ?, NOW())");
    return $stmt->execute([$login, $hashedPassword]);
}
}
?>