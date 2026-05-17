<?php
require_once '../config/helpers.php';
require_once '../models/db.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';
$db = new db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'add') {
        $product_id = intval($_POST['product_id']);
        $product = $db->getProductById($product_id);

        if ($product) {
            if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
            
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id]++;
            } else {
                $_SESSION['cart'][$product_id] = 1;
            }

            // Cap at available stock
            if ($_SESSION['cart'][$product_id] > $product['stock_qty']) {
                $_SESSION['cart'][$product_id] = $product['stock_qty'];
            }

            echo json_encode([
                'success' => true, 
                'cart_count' => array_sum($_SESSION['cart'])
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Product not found']);
        }
    }
}
?>
