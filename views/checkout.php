<?php
include '../config/helpers.php';
include '../models/db.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$db = new db();
$user = $db->getUserById($_SESSION['user_id']);
$addresses = json_decode($user['shipping_addresses'] ?? '[]', true);
$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    setFlash('error', "Your cart is empty");
    redirect('index.php');
}

$total = 0;
$cart_items = [];
foreach ($cart as $id => $qty) {
    $product = $db->getProductById($id);
    if ($product) {
        $product['quantity'] = $qty;
        $total += $product['price'] * $qty;
        $cart_items[] = $product;
    }
}

include 'header.php';
?>

<div class="checkout-container card">
    <h2>Checkout</h2>
    <form action="../controllers/OrderController.php" method="POST">
        <div class="checkout-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
            <div class="shipping-info">
                <h3>Shipping Address</h3>
                <?php foreach ($addresses as $index => $addr): ?>
                    <?php if (!empty($addr)): ?>
                        <div class="form-group">
                            <label>
                                <input type="radio" name="shipping_address" value="<?php echo htmlspecialchars($addr); ?>" <?php echo $index === 0 ? 'checked' : ''; ?>>
                                <?php echo htmlspecialchars($addr); ?>
                            </label>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
                
                <div class="form-group">
                    <label>
                        <input type="radio" name="shipping_address" value="new" <?php echo empty($addresses) ? 'checked' : ''; ?>>
                        Use a new address:
                    </label>
                    <textarea name="new_address" rows="3" placeholder="Enter new address..."></textarea>
                </div>

                <h3>Payment Method</h3>
                <div class="form-group">
                    <label><input type="radio" name="payment_method" value="Cash" checked> Cash on Delivery</label>
                    <label><input type="radio" name="payment_method" value="Card"> Credit Card</label>
                </div>
            </div>

            <div class="order-summary">
                <h3>Order Summary</h3>
                <table>
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?> x <?php echo $item['quantity']; ?></td>
                            <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr style="font-weight: bold; font-size: 1.2em;">
                        <td>Total</td>
                        <td>$<?php echo number_format($total, 2); ?></td>
                    </tr>
                </table>
                <button type="submit" class="btn" style="width: 100%; margin-top: 20px;">Place Order</button>
            </div>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>
