<?php
require_once '../config/helpers.php';
require_once '../models/db.php';

header('Content-Type: application/json');

$db = new db();
$action = $_GET['action'] ?? '';

if ($action === 'search') {
    $q = $_GET['q'] ?? '';
    $products = $db->getAllProducts(['search' => $q]);
    echo json_encode($products);
} 
elseif ($action === 'filter') {
    $category_id = intval($_GET['category_id'] ?? 0);
    $products = $db->getAllProducts(['category_id' => $category_id]);
    echo json_encode($products);
}
else {
    $products = $db->getAllProducts();
    echo json_encode($products);
}
?>
