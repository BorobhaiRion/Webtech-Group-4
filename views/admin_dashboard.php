<?php
include '../config/helpers.php';
include '../models/db.php';

requireAdmin();

include 'header.php';

$db = new db();
$categories = $db->getAllCategories();
$products = $db->getAllProducts(['show_unavailable' => true]);
?>

<div class="admin-container">
    <h2>Admin Dashboard</h2>
    
    <table class="layout-table">
        <tr>
            <td width="50%">
                <div class="admin-card">
                    <h3>Quick Stats</h3>
                    <table class="stats-table">
                        <tr>
                            <td><strong>Total Products:</strong></td>
                            <td><?php echo count($products); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Total Categories:</strong></td>
                            <td><?php echo count($categories); ?></td>
                        </tr>
                    </table>
                </div>
            </td>
            <td width="50%">
                <div class="admin-actions">
                    <h3>Management</h3>
                    <table class="form-table" style="border: none;">
                        <tr>
                            <td><a href="admin_product_form.php" class="btn" style="display: block; text-align: center;">Add New Product</a></td>
                            <td><a href="admin_category_form.php" class="btn secondary" style="display: block; text-align: center;">Add New Category</a></td>
                        </tr>
                        <tr>
                            <td colspan="2"><a href="admin_orders.php" class="btn" style="display: block; text-align: center;">View All Orders</a></td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <div class="products-list card" style="margin-top: 20px;">
        <h3>Product Inventory</h3>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Availability</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                    <tr class="<?php echo ($p['stock_qty'] <= 5) ? 'stock-alert' : ''; ?>">
                        <td>#<?php echo $p['id']; ?></td>
                        <td><?php echo htmlspecialchars($p['name']); ?></td>
                        <td>$<?php echo $p['price']; ?></td>
                        <td><?php echo $p['stock_qty']; ?></td>
                        <td>
                            <span id="avail-badge-<?php echo $p['id']; ?>" class="status-badge <?php echo $p['is_available'] ? 'delivered' : 'pending'; ?>" 
                                  style="cursor: pointer;" onclick="toggleAvailability(<?php echo $p['id']; ?>)">
                                <?php echo $p['is_available'] ? 'In Stock' : 'Out of Stock'; ?>
                            </span>
                        </td>
                        <td>
                            <a href="admin_product_form.php?id=<?php echo $p['id']; ?>" class="btn-small">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="categories-list card" style="margin-top: 20px;">
        <h3>Category Management</h3>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Parent ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td>#<?php echo $cat['id']; ?></td>
                        <td><?php echo htmlspecialchars($cat['name']); ?></td>
                        <td><?php echo $cat['parent_id'] ? '#' . $cat['parent_id'] : 'Root'; ?></td>
                        <td>
                            <a href="admin_category_form.php?id=<?php echo $cat['id']; ?>" class="btn-small">Edit</a>
                            <form action="../controllers/AdminController.php" method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="delete_category">
                                <input type="hidden" name="id" value="<?php echo $cat['id']; ?>">
                                <button type="submit" class="btn-small" style="background: #ff4444;" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function toggleAvailability(id) {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let res = JSON.parse(this.responseText);
            if (res.ok) {
                let badge = document.getElementById('avail-badge-' + id);
                if (res.is_available) {
                    badge.innerText = 'In Stock';
                    badge.className = 'status-badge delivered';
                } else {
                    badge.innerText = 'Out of Stock';
                    badge.className = 'status-badge pending';
                }
            }
        }
    };
    xhttp.open("POST", "../api/toggle_availability.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id=" + id);
}
</script>

<style>
.stock-alert { background-color: #ffeeba !important; }
.admin-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.action-links { display: flex; gap: 10px; flex-wrap: wrap; }
</style>

<?php include 'footer.php'; ?>
