<?php
include '../config/helpers.php';
include '../models/db.php';
include 'header.php';

$id = $_GET['id'] ?? 0;
$db = new db();
$product = $db->getProductById($id);

if (!$product) {
    echo "Product not found.";
    include 'footer.php';
    exit();
}
?>

<div class="product-detail">
    <div class="product-image">
        <img src="../public/uploads/products/<?php echo $product['primary_image_path'] ?: 'default.png'; ?>" alt="<?php echo $product['name']; ?>">
    </div>
    <div class="product-info">
        <h2><?php echo $product['name']; ?></h2>
        <p class="category">Category: <?php echo $product['category_name']; ?></p>
        <p class="price">$<?php echo $product['price']; ?></p>
        <p class="stock">Status: <?php echo ($product['stock_qty'] > 0) ? 'In Stock (' . $product['stock_qty'] . ')' : 'Out of Stock'; ?></p>
        <p class="description"><?php echo $product['description']; ?></p>
        
        <?php if ($product['stock_qty'] > 0): ?>
            <button onclick="addToCart(<?php echo $product['id']; ?>)" class="btn">Add to Cart</button>
        <?php endif; ?>
    </div>
</div>

<div class="reviews-section">
    <h3>Reviews</h3>
    
    <p>No reviews yet.</p>
</div>

<?php include 'footer.php'; ?>