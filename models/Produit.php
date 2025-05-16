<?php
require_once __DIR__ . '/../config/database.php';

class Produit {
    private $conn;
    private $table_name = "produit";

    // Object properties
    public $id;
    public $libelle;
    public $description;
    public $prix;
    public $photo;
    public $stock;
    public $date_creation;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Create new product
    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                (libelle, description, prix, photo, stock, date_creation)
                VALUES
                (:libelle, :description, :prix, :photo, :stock, :date_creation)";

        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $this->libelle = htmlspecialchars(strip_tags($this->libelle));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->prix = htmlspecialchars(strip_tags($this->prix));
        $this->photo = htmlspecialchars(strip_tags($this->photo));
        $this->stock = htmlspecialchars(strip_tags($this->stock));
        $this->date_creation = date('Y-m-d H:i:s');

        // Bind values
        $stmt->bindParam(":libelle", $this->libelle);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":prix", $this->prix);
        $stmt->bindParam(":photo", $this->photo);
        $stmt->bindParam(":stock", $this->stock);
        $stmt->bindParam(":date_creation", $this->date_creation);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Read single product
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->libelle = $row['libelle'];
            $this->description = $row['description'];
            $this->prix = $row['prix'];
            $this->photo = $row['photo'];
            $this->stock = $row['stock'];
            $this->date_creation = $row['date_creation'];
            return true;
        }
        return false;
    }

    // Read all products
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Update product
    public function update() {
        $query = "UPDATE " . $this->table_name . "
                SET
                    libelle = :libelle,
                    description = :description,
                    prix = :prix,
                    photo = :photo,
                    stock = :stock
                WHERE
                    id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $this->libelle = htmlspecialchars(strip_tags($this->libelle));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->prix = htmlspecialchars(strip_tags($this->prix));
        $this->photo = htmlspecialchars(strip_tags($this->photo));
        $this->stock = htmlspecialchars(strip_tags($this->stock));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind values
        $stmt->bindParam(":libelle", $this->libelle);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":prix", $this->prix);
        $stmt->bindParam(":photo", $this->photo);
        $stmt->bindParam(":stock", $this->stock);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete product
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

    // Search products
    public function search($keywords) {
        $query = "SELECT * FROM " . $this->table_name . "
                WHERE libelle LIKE ? OR description LIKE ? OR prix LIKE ?
                ORDER BY date_creation DESC";

        $stmt = $this->conn->prepare($query);

        // Sanitize keywords
        $keywords = htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";

        // Bind parameters
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);

        $stmt->execute();
        return $stmt;
    }

    // Get all products
    public function getAllProducts() {
        $query = "SELECT id, libelle, description, prix, photo, stock FROM " . $this->table_name . " ORDER BY date_creation DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Count total products
    public function countProducts() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    // Get latest products
    public function getLatestProducts($limit = 5) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 ORDER BY date_creation DESC 
                 LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }
}
?> 