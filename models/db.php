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
    public function registerUser($name, $email, $phone, $password_hash, $role = 'customer') {
        $conn = $this->connection();
        $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password_hash, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $password_hash, $role);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $result;
    }
    public function getUserByEmail($email) {
        $conn = $this->connection();
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        $conn->close();
        return $user;
    }

    public function getUserById($id) {
        $conn = $this->connection();
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        $conn->close();
        return $user;
    }
    public function updateUserProfile($id, $name, $email, $phone, $addresses) {
        $conn = $this->connection();
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, phone = ?, shipping_addresses = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $name, $email, $phone, $addresses, $id);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $result;
    }

    public function updatePassword($id, $new_hash) {
        $conn = $this->connection();
        $stmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        $stmt->bind_param("si", $new_hash, $id);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $result;
    }

    public function updateRememberToken($id, $token) {
        $conn = $this->connection();
        $stmt = $conn->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
        $stmt->bind_param("si", $token, $id);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $result;
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
        // Check if product has order items
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
        // Check if category has products
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
