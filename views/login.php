<?php
include '../config/helpers.php';
include 'header.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Log in Form</title>
    </head>
<body>

<div class="auth-form" style="max-width: 500px; margin: 20px auto;">
    <table class="layout-table">
        
        <tr>
            <td style="background: #00c8ff;"><h2 align="Center">Log In</h2></td>
        </tr>
        <tr>
            <td>
                <form action="../controllers/LoginController.php" method="POST">
                    <table class="form-table"style="margin-top:10px;">

                        <tr>
                            <td width="150"><label>Email</label></td>
                            <td><input type="email" name="email" required></td>
                        </tr>

                         <tr>
                            <td width="150"><label>Password</label></td>
                            <td><input type="password" name="password" required></td>
                        </tr>

                        <tr>
                            <td><label><input type="checkbox" name="remember"> Remember Me</label></td>
                        </tr>

                        <tr>
                            <td width="150"></td>
                            <td><input type="submit" name="submit" value="Log In" style="margin-top:20px;"></td>
                        </tr>


                    </table>
                </form>
                <p style="margin-top: 10px;text-align: center;">Don't have an account? <a href="register.php">Register here</a></p>
            </td>
        </tr>
    </table>
</div>
<body>
</html>


<?php include 'footer.php'; ?>