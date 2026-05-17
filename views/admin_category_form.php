<?php
include '../config/helpers.php';
include '../models/db.php';

requireAdmin();

$db = new db();
$categories = $db->getAllCategories();
$category = null;

if (isset($_GET['id'])) {
    $category = $db->getCategoryById(intval($_GET['id']));
}

include 'header.php';
?>

<div class="admin-form-container card">
    <table class="layout-table">
        <tr>
            <td style="background: #eee;"><h2><?php echo $category ? 'Edit Category' : 'Add New Category'; ?></h2></td>
        </tr>
        <tr>
            <td>
                <form action="../controllers/AdminController.php" method="POST">
                    <input type="hidden" name="action" value="<?php echo $category ? 'edit_category' : 'add_category'; ?>">
                    <?php if ($category): ?>
                        <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                    <?php endif; ?>

                    <table class="form-table">
                        <tr>
                            <td width="200"><label>Category Name</label></td>
                            <td><input type="text" name="name" value="<?php echo $category['name'] ?? ''; ?>" required></td>
                        </tr>
                        <tr>
                            <td><label>Parent Category (Optional)</label></td>
                            <td>
                                <select name="parent_id">
                                    <option value="">None (Root Category)</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <?php if ($category && $category['id'] == $cat['id']) continue; // Can't be own parent ?>
                                        <option value="<?php echo $cat['id']; ?>" <?php echo (isset($category['parent_id']) && $category['parent_id'] == $cat['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($cat['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="form-actions">
                                <button type="submit" class="btn"><?php echo $category ? 'Update' : 'Create'; ?> Category</button>
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
