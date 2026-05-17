<?php
require_once '../config/helpers.php';
require_once '../models/db.php';

header('Content-Type: application/json');

if (!isAdmin()) {
    echo json_encode(['ok' => false, 'message' => 'Unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $db = new db();
    $product = $db->getProductById($id);

    if ($product) {
        $new_status = $product['is_available'] ? 0 : 1;
        if ($db->updateProductAvailability($id, $new_status)) {
            echo json_encode(['ok' => true, 'is_available' => $new_status]);
        } else {
            echo json_encode(['ok' => false, 'message' => 'Update failed']);
        }
    } else {
        echo json_encode(['ok' => false, 'message' => 'Product not found']);
    }
}
?>
