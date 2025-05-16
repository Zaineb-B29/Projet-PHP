<?php
require_once __DIR__ . '/../config/database.php';

class Admin {
    private $conn;
    private $table_name = "admin";

    // Object properties
    public $id;
    public $username;
    public $password;
    public $email;
    public $full_name;
    public $created_at;
    public $updated_at;
    public $last_login;
    public $is_active;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Create new admin
    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                (username, password, email, full_name)
                VALUES
                (:username, :password, :email, :full_name)";

        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->full_name = htmlspecialchars(strip_tags($this->full_name));
        
        // Hash the password
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        // Bind values
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":full_name", $this->full_name);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Read single admin
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->username = $row['username'];
            $this->email = $row['email'];
            $this->full_name = $row['full_name'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
            $this->last_login = $row['last_login'];
            $this->is_active = $row['is_active'];
            return true;
        }
        return false;
    }

    // Update admin
    public function update() {
        $query = "UPDATE " . $this->table_name . "
                SET
                    username = :username,
                    email = :email,
                    full_name = :full_name,
                    is_active = :is_active
                WHERE
                    id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->full_name = htmlspecialchars(strip_tags($this->full_name));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind values
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":full_name", $this->full_name);
        $stmt->bindParam(":is_active", $this->is_active);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete admin
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Login admin
    public function login($username, $password) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM admin WHERE username = ?");
            $stmt->execute([$username]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin && password_verify($password, $admin['password'])) {
                $this->id = $admin['id'];
                $this->username = $admin['username'];
                return true;
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Update last login
    private function updateLastLogin() {
        $query = "UPDATE " . $this->table_name . " SET last_login = CURRENT_TIMESTAMP WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
    }

    // Change password
    public function changePassword($new_password) {
        $query = "UPDATE " . $this->table_name . " SET password = :password WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function register($username, $password) {
        try {
            // Check if username already exists
            $stmt = $this->conn->prepare("SELECT id FROM admin WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->fetch()) {
                return false; // Username already exists
            }

            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new admin
            $stmt = $this->conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
            return $stmt->execute([$username, $hashed_password]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Get all admins
    public function getAllAdmins() {
        $query = "SELECT id, username, created_at FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Delete admin by ID
    public function deleteAdmin($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
?> 