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

    
    public function createOrder($user_id, $total, $address, $method) {
        $conn = $this->connection();
        $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, shipping_address, payment_method) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("idss", $user_id, $total, $address, $method);
        $result = $stmt->execute();
        $order_id = $conn->insert_id;
        $stmt->close();
        $conn->close();
        return $result ? $order_id : false;
    }

    public function addOrderItem($order_id, $product_id, $qty, $price) {
        $conn = $this->connection();
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $order_id, $product_id, $qty, $price);
        $result = $stmt->execute();
        
        // Decrement stock
        $stmt2 = $conn->prepare("UPDATE products SET stock_qty = stock_qty - ? WHERE id = ?");
        $stmt2->bind_param("ii", $qty, $product_id);
        $stmt2->execute();
        
        $stmt->close();
        $stmt2->close();
        $conn->close();
        return $result;
    }

    public function getUserOrders($user_id) {
        $conn = $this->connection();
        $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $orders = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        $conn->close();
        return $orders;
    }

}
?>
