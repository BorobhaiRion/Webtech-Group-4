<?php
include '../config/helpers.php';
include 'header.php';
?>

<div class="auth-form" style="max-width: 500px; margin: 20px auto;">
    <table class="layout-table">
        <tr>
            <td style="background: #eee;"><h2>Login</h2></td>
        </tr>
        <tr>
            <td>
                <form action="../controllers/LoginController.php" method="POST">
                    <table class="form-table">
                        <tr>
                            <td width="150"><label>Email</label></td>
                            <td><input type="email" name="email" required></td>
                        </tr>
                        <tr>
                            <td><label>Password</label></td>
                            <td><input type="password" name="password" required></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><label><input type="checkbox" name="remember"> Remember Me</label></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><button type="submit" class="btn">Login</button></td>
                        </tr>
                    </table>
                </form>
                <p style="margin-top: 15px;">Don't have an account? <a href="register.php">Register here</a></p>
            </td>
        </tr>
    </table>
</div>

<?php include 'footer.php'; ?>
