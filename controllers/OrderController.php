<?php
require_once '../config/helpers.php';
require_once '../models/db.php';

if (!isLoggedIn()) {
    redirect('../views/login.php');
}

$db = new db();
$user_id = $_SESSION['user_id'];
$cart = $_SESSION['cart'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($cart)) {
        setFlash('error', "Cart is empty");
        redirect('../views/index.php');
    }

    $shipping_address = $_POST['shipping_address'];
    if ($shipping_address === 'new') {
        $shipping_address = validateInput($_POST['new_address']);
    }
    
    $payment_method = $_POST['payment_method'];

    $total = 0;
    $items_to_save = [];
    foreach ($cart as $id => $qty) {
        $product = $db->getProductById($id);
        if ($product) {
            if ($product['stock_qty'] < $qty) {
                setFlash('error', "Insufficient stock for " . $product['name']);
                redirect('../views/cart.php');
            }
            $total += $product['price'] * $qty;
            $items_to_save[] = [
                'id' => $id,
                'qty' => $qty,
                'price' => $product['price']
            ];
        }
    }

    $order_id = $db->createOrder($user_id, $total, $shipping_address, $payment_method);
    if ($order_id) {
        foreach ($items_to_save as $item) {
            $db->addOrderItem($order_id, $item['id'], $item['qty'], $item['price']);
        }
        
        unset($_SESSION['cart']);
        setFlash('success', "Order placed successfully! Order ID: #" . $order_id);
        redirect('../views/order_confirmation.php?id=' . $order_id);
    } else {
        setFlash('error', "Failed to place order");
        redirect('../views/checkout.php');
    }
}
?>
