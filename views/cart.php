<?php
include '../config/helpers.php';
include '../models/db.php';
include 'header.php';

$db = new db();
$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>

<h2>Your Shopping Cart</h2>

<?php if (empty($cart)): ?>
    <p>Your cart is empty. <a href="index.php">Go shopping!</a></p>
<?php else: ?>
    <table class="cart-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cart as $id => $qty): 
                $product = $db->getProductById($id);
                $subtotal = $product['price'] * $qty;
                $total += $subtotal;
            ?>
                <tr>
                    <td><?php echo $product['name']; ?></td>
                    <td>$<?php echo $product['price']; ?></td>
                    <td>
                        <form action="../controllers/CartController.php?action=update" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                            <input type="number" name="qty" value="<?php echo $qty; ?>" min="1" onchange="this.form.submit()">
                        </form>
                    </td>
                    <td>$<?php echo $subtotal; ?></td>
                    <td><a href="../controllers/CartController.php?action=remove&product_id=<?php echo $id; ?>">Remove</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="cart-summary">
        <h3>Total: $<?php echo $total; ?></h3>
        <a href="checkout.php" class="btn">Proceed to Checkout</a>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>
