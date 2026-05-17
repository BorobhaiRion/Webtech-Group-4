<?php
include '../config/helpers.php';
include '../models/db.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

include 'header.php';

$db = new db();
$user = $db->getUserById($_SESSION['user_id']);
$orders = $db->getUserOrders($_SESSION['user_id']);
$addresses = json_decode($user['shipping_addresses'] ?? '[]', true);
$addr1 = $addresses[0] ?? '';
$addr2 = $addresses[1] ?? '';
?>

<div class="profile-container">
    <h2>My Profile</h2>
    
    <table class="layout-table">
        <tr>
            <td width="50%">
                <div class="profile-info">
                    <h3>Update Information</h3>
                    <form action="../controllers/ProfileController.php" method="POST">
                        <input type="hidden" name="action" value="update_profile">
                        <table class="form-table">
                            <tr>
                                <td><label>Name</label></td>
                                <td><input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required></td>
                            </tr>
                            <tr>
                                <td><label>Email</label></td>
                                <td><input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required></td>
                            </tr>
                            <tr>
                                <td><label>Phone</label></td>
                                <td><input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>"></td>
                            </tr>
                            <tr>
                                <td><label>Shipping Address 1</label></td>
                                <td><input type="text" name="address1" value="<?php echo htmlspecialchars($addr1); ?>"></td>
                            </tr>
                            <tr>
                                <td><label>Shipping Address 2</label></td>
                                <td><input type="text" name="address2" value="<?php echo htmlspecialchars($addr2); ?>"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><button type="submit" class="btn">Update Profile</button></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </td>
            <td width="50%">
                <div class="password-change">
                    <h3>Change Password</h3>
                    <form action="../controllers/ProfileController.php" method="POST">
                        <input type="hidden" name="action" value="change_password">
                        <table class="form-table">
                            <tr>
                                <td><label>Current Password</label></td>
                                <td><input type="password" name="current_password" required></td>
                            </tr>
                            <tr>
                                <td><label>New Password</label></td>
                                <td><input type="password" name="new_password" required minlength="8"></td>
                            </tr>
                            <tr>
                                <td><label>Confirm Password</label></td>
                                <td><input type="password" name="confirm_password" required minlength="8"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><button type="submit" class="btn secondary">Change Password</button></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </td>
        </tr>
    </table>

    <div class="order-history card" style="margin-top: 20px;">
        <h3>Order History</h3>
        <?php if (empty($orders)): ?>
            <p>You haven't placed any orders yet.</p>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?php echo $order['id']; ?></td>
                            <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                            <td>$<?php echo $order['total_amount']; ?></td>
                            <td><span class="status-badge <?php echo strtolower($order['status']); ?>"><?php echo $order['status']; ?></span></td>
                            <td><a href="order_confirmation.php?id=<?php echo $order['id']; ?>" class="btn-small">View Details</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
