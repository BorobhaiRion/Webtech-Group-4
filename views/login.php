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
                    <table class="form-table">




                    </table>
                </form>
                <p style="margin-top: 10px;text-align: center;">Don't have an account? <a href="registration.php">Register here</a></p>
            </td>
        </tr>
    </table>
</div>
<body>
</html>


<?php include 'footer.php'; ?>