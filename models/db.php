<?php
class db {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $dbname = "shop_db";

    public function connection() {
        $conn = new mysqli($this->host, $this->user, $this->password, $this->dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
    
     // Category methods
    public function getAllCategories() {
        $conn = $this->connection();
        $result = $conn->query("SELECT * FROM categories");
        $categories = $result->fetch_all(MYSQLI_ASSOC);
        $conn->close();
        return $categories;
    }

// Product methods
    public function getAllProducts($filters = []) {
        $conn = $this->connection();
        $sql = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE 1=1";
        
        if (!isset($filters['show_unavailable']) || !$filters['show_unavailable']) {
            $sql .= " AND p.is_available = 1";
        }
        
        if (!empty($filters['category_id'])) {
            $sql .= " AND p.category_id = " . intval($filters['category_id']);
        }
        if (!empty($filters['search'])) {
            $sql .= " AND p.name LIKE '%" . $conn->real_escape_string($filters['search']) . "%'";
        }
        
        $result = $conn->query($sql);
        $products = $result->fetch_all(MYSQLI_ASSOC);
        $conn->close();
        return $products;
    }

    
    public function getProductById($id) {
        $conn = $this->connection();
        $stmt = $conn->prepare("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();
        $conn->close();
        return $product;
    }

    public function updateProductAvailability($id, $status) {
        $conn = $this->connection();
        $stmt = $conn->prepare("UPDATE products SET is_available = ? WHERE id = ?");
        $stmt->bind_param("ii", $status, $id);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $result;
    }

    public function addProduct($name, $category_id, $description, $price, $stock_qty, $image) {
        $conn = $this->connection();
        $stmt = $conn->prepare("INSERT INTO products (name, category_id, description, price, stock_qty, primary_image_path) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sisdis", $name, $category_id, $description, $price, $stock_qty, $image);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $result;
    }

    public function updateProduct($id, $name, $category_id, $description, $price, $stock_qty, $image = null) {
        $conn = $this->connection();
        if ($image) {
            $stmt = $conn->prepare("UPDATE products SET name = ?, category_id = ?, description = ?, price = ?, stock_qty = ?, primary_image_path = ? WHERE id = ?");
            $stmt->bind_param("sisdisi", $name, $category_id, $description, $price, $stock_qty, $image, $id);
        } else {
            $stmt = $conn->prepare("UPDATE products SET name = ?, category_id = ?, description = ?, price = ?, stock_qty = ? WHERE id = ?");
            $stmt->bind_param("sisdii", $name, $category_id, $description, $price, $stock_qty, $id);
        }
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $result;
    }

    public function deleteProduct($id) {
        $conn = $this->connection();
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM order_items WHERE product_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        if ($res['count'] > 0) return false;

        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $result;
    }

    public function addCategory($name, $parent_id = null) {
        $conn = $this->connection();
        $stmt = $conn->prepare("INSERT INTO categories (name, parent_id) VALUES (?, ?)");
        $stmt->bind_param("si", $name, $parent_id);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $result;
    }

    public function updateCategory($id, $name, $parent_id = null) {
        $conn = $this->connection();
        $stmt = $conn->prepare("UPDATE categories SET name = ?, parent_id = ? WHERE id = ?");
        $stmt->bind_param("sii", $name, $parent_id, $id);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $result;
    }

    public function deleteCategory($id) {
        $conn = $this->connection();
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM products WHERE category_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        if ($res['count'] > 0) return false;

        $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $result;
    }

}
?>
