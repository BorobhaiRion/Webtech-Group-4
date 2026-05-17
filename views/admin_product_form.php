<?php
include '../config/helpers.php';
include '../models/db.php';

requireAdmin();

$db = new db();
$categories = $db->getAllCategories();
$product = null;

if (isset($_GET['id'])) {
    $product = $db->getProductById(intval($_GET['id']));
}

include 'header.php';
?>

<div class="admin-form-container card">
    <table class="layout-table">
        <tr>
            <td style="background: #eee;"><h2><?php echo $product ? 'Edit Product' : 'Add New Product'; ?></h2></td>
        </tr>
        <tr>
            <td>
                <form action="../controllers/AdminController.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="<?php echo $product ? 'edit_product' : 'add_product'; ?>">
                    <?php if ($product): ?>
                        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                    <?php endif; ?>

                    <table class="form-table">
                        <tr>
                            <td width="200"><label>Product Name</label></td>
                            <td><input type="text" name="name" value="<?php echo $product['name'] ?? ''; ?>" required></td>
                        </tr>
                        <tr>
                            <td><label>Category</label></td>
                            <td>
                                <select name="category_id" required>
                                    <option value="">Select Category</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo $cat['id']; ?>" <?php echo (isset($product['category_id']) && $product['category_id'] == $cat['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($cat['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label>Description</label></td>
                            <td><textarea name="description" rows="4"><?php echo $product['description'] ?? ''; ?></textarea></td>
                        </tr>
                        <tr>
                            <td><label>Price ($)</label></td>
                            <td><input type="number" step="0.01" name="price" value="<?php echo $product['price'] ?? ''; ?>" required></td>
                        </tr>
                        <tr>
                            <td><label>Stock Quantity</label></td>
                            <td><input type="number" name="stock_qty" value="<?php echo $product['stock_qty'] ?? ''; ?>" required></td>
                        </tr>
                        <tr>
                            <td><label>Product Image</label></td>
                            <td>
                                <?php if (isset($product['primary_image_path'])): ?>
                                    <div style="margin-bottom: 10px;">
                                        <img src="../public/uploads/products/<?php echo $product['primary_image_path']; ?>" width="100">
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="image" accept="image/jpeg,image/png">
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="form-actions">
                                <button type="submit" class="btn"><?php echo $product ? 'Update' : 'Create'; ?> Product</button>
                                <a href="admin_dashboard.php" class="btn secondary">Cancel</a>
                            </td>
                        </tr>
                    </table>
                </form>
            </td>
        </tr>
    </table>
</div>

<?php include 'footer.php'; ?>
