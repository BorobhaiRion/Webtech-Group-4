<?php
require_once '../config/helpers.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$action = $_GET['action'] ?? '';

if ($action === 'add') {
    $productId = $_POST['product_id'];
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]++;
    } else {
        $_SESSION['cart'][$productId] = 1;
    }
    
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'cart_count' => count($_SESSION['cart'])]);
    exit();
}

if ($action === 'update') {
    $productId = $_POST['product_id'];
    $qty = intval($_POST['qty']);
    if ($qty > 0) {
        $_SESSION['cart'][$productId] = $qty;
    } else {
        unset($_SESSION['cart'][$productId]);
    }
    redirect('../views/cart.php');
}

if ($action === 'remove') {
    $productId = $_GET['product_id'];
    unset($_SESSION['cart'][$productId]);
    redirect('../views/cart.php');
}
?>
