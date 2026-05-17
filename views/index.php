<?php
include '../config/helpers.php';
include '../models/db.php';
include 'header.php';

$db = new db();
$categories = $db->getAllCategories();
$products = $db->getAllProducts();
?>

<table class="layout-table" style="border: none; margin-bottom: 0;">
    <tr>
        <td width="200" style="vertical-align: top; border: 1px solid #ccc; background: #f9f9f9;">
            <aside class="filters">
                <h3>Categories</h3>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin-bottom: 10px;"><a href="#" onclick="filterCategory(0)">All</a></li>
                    <?php foreach ($categories as $cat): ?>
                        <li style="margin-bottom: 10px;"><a href="#" onclick="filterCategory(<?php echo $cat['id']; ?>)"><?php echo $cat['name']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </aside>
        </td>
        <td style="vertical-align: top; padding-left: 20px; border: 1px solid #ccc;">
            <main class="products-main">
                <div class="search-bar" style="margin-bottom: 20px;">
                    <input type="text" id="search-input" placeholder="Search products..." onkeyup="searchProducts()" style="width: 100%; padding: 10px;">
                </div>

                <div id="product-list">
                    <table class="product-table">
                        <?php 
                        $cols = 4;
                        $count = count($products);
                        for ($i = 0; $i < $count; $i++): 
                            if ($i % $cols == 0) echo "<tr>";
                            $product = $products[$i];
                        ?>
                            <td>
                                <img src="../public/uploads/products/<?php echo $product['primary_image_path'] ?: 'default.png'; ?>" alt="<?php echo $product['name']; ?>">
                                <h4 style="margin: 10px 0;"><?php echo $product['name']; ?></h4>
                                <span class="price">$<?php echo $product['price']; ?></span>
                                <div style="margin-top: 10px;">
                                    <a href="product_detail.php?id=<?php echo $product['id']; ?>" class="btn-small" style="display: block; margin-bottom: 5px;">View Details</a>
                                    <button onclick="addToCart(<?php echo $product['id']; ?>)" class="btn-small secondary" style="display: block; width: 100%; cursor: pointer;">Add to Cart</button>
                                </div>
                            </td>
                        <?php 
                            if (($i + 1) % $cols == 0 || ($i + 1) == $count) {
                                // Fill empty cells if last row is incomplete
                                if (($i + 1) == $count) {
                                    $remaining = $cols - (($i + 1) % $cols);
                                    if ($remaining < $cols) {
                                        for ($j = 0; $j < $remaining; $j++) echo "<td></td>";
                                    }
                                }
                                echo "</tr>";
                            }
                        endfor; 
                        ?>
                    </table>
                </div>
            </main>
        </td>
    </tr>
</table>

<?php include 'footer.php'; ?>
