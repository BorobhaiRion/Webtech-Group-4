<?php
include '../config/helpers.php';
include '../models/db.php';
include 'header.php';

$id = $_GET['id'] ?? 0;
?>

<div class="confirmation">
    <h2>Order #<?php echo $id; ?> Placed!</h2>
    <p>Thank you for your purchase. Your order is now being processed.</p>
    <a href="index.php" class="btn">Continue Shopping</a>
</div>

<?php include 'footer.php'; ?>
