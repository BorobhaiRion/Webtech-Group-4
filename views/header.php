<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Store</title>
    <link rel="stylesheet" href="../public/assets/css/style.css">
</head>
<body>
    <table class="layout-table layout-header">
        <tr>
            <td width="200">
                <a href="index.php" class="logo" style="color: #fff; text-decoration: none; font-size: 24px; font-weight: bold;">E-Store</a>
            </td>
            <td>
                <nav>
                    <ul class="nav-links">
                        <li><a href="index.php">Home</a></li>
                        <?php if (isLoggedIn()): ?>
                            <li><a href="profile.php">Profile</a></li>
                            <li><a href="cart.php">Cart (<span id="cart-count"><?php echo count($_SESSION['cart'] ?? []); ?></span>)</a></li>
                            <?php if (isAdmin()): ?>
                                <li><a href="admin_dashboard.php">Admin</a></li>
                            <?php endif; ?>
                            <li><a href="logout.php">Logout</a></li>
                        <?php else: ?>
                            <li><a href="login.php">Login</a></li>
                            <li><a href="register.php">Register</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </td>
        </tr>
    </table>

    <div class="container">
        <table class="layout-table">
            <tr>
                <td>
                    <?php
                    $error = getFlash('error');
                    if ($error) echo "<div class='alert alert-danger'>$error</div>";
                    $success = getFlash('success');
                    if ($success) echo "<div class='alert alert-success'>$success</div>";
                    ?>
