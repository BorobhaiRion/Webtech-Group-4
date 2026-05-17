<?php
require_once '../config/helpers.php';
require_once '../models/db.php';

$action = $_GET['action'] ?? 'list';
$db = new db();

if ($action === 'search' || $action === 'filter') {
    $filters = [];
    if (!empty($_GET['category_id'])) $filters['category_id'] = $_GET['category_id'];
    if (!empty($_GET['q'])) $filters['search'] = $_GET['q'];

    $products = $db->getAllProducts($filters);
    
    header('Content-Type: application/json');
    echo json_encode($products);
    exit();
}
?>