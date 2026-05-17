<?php
require_once '../config/helpers.php';
require_once '../models/db.php';

requireAdmin();

$db = new db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add_product' || $action === 'edit_product') {
        $name = validateInput($_POST['name']);
        $category_id = intval($_POST['category_id']);
        $description = validateInput($_POST['description']);
        $price = floatval($_POST['price']);
        $stock_qty = intval($_POST['stock_qty']);
        
        $image_name = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $allowed = ['image/jpeg', 'image/png'];
            if (in_array($_FILES['image']['type'], $allowed) && $_FILES['image']['size'] <= 3 * 1024 * 1024) {
                $image_name = time() . '_' . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], '../public/uploads/products/' . $image_name);
            }
        }

        if ($action === 'add_product') {
            if ($db->addProduct($name, $category_id, $description, $price, $stock_qty, $image_name)) {
                setFlash('success', "Product added successfully");
            } else {
                setFlash('error', "Failed to add product");
            }
        } else {
            $id = intval($_POST['id']);
            if ($db->updateProduct($id, $name, $category_id, $description, $price, $stock_qty, $image_name)) {
                setFlash('success', "Product updated successfully");
            } else {
                setFlash('error', "Failed to update product");
            }
        }
    } elseif ($action === 'add_category') {
        $name = validateInput($_POST['name']);
        $parent_id = !empty($_POST['parent_id']) ? intval($_POST['parent_id']) : null;

        if ($db->addCategory($name, $parent_id)) {
            setFlash('success', "Category added successfully");
        } else {
            setFlash('error', "Failed to add category");
        }
    } elseif ($action === 'edit_category') {
        $id = intval($_POST['id']);
        $name = validateInput($_POST['name']);
        $parent_id = !empty($_POST['parent_id']) ? intval($_POST['parent_id']) : null;

        if ($db->updateCategory($id, $name, $parent_id)) {
            setFlash('success', "Category updated successfully");
        } else {
            setFlash('error', "Failed to update category");
        }
    } elseif ($action === 'delete_category') {
        $id = intval($_POST['id']);
        if ($db->deleteCategory($id)) {
            setFlash('success', "Category deleted successfully");
        } else {
            setFlash('error', "Failed to delete category (it may have products)");
        }
    }
    
    redirect('../views/admin_dashboard.php');
}
?>
