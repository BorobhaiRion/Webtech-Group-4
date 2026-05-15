<?php
include '../config/helpers.php';
include 'header.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Registration Form</title>
    </head>
<body>

<div class="auth-form" style="max-width: 500px; margin: 20px auto;">
    <table class="layout-table">
        
        <tr>
            <td style="background: #00c8ff;"><h2 align="Center">Register</h2></td>
        </tr>
        <tr>
            <td>
                <form action="../controllers/RegisterController.php" method="POST">
                    <table class="form-table">

                         <tr>
                            <td><p style = 'color: red '>* Required Field </p></td>
                         </tr>

                         <tr>
                            <td width="150"><label>Name</label></td>
                            <td><input type="text" name="name"></td>
                            <td><p style = 'color: red'>*</p></td>
                        </tr>

                        <tr>
                            <td width="150"><label>Email</label></td>
                            <td><input type="email" name="email"></td>
                            <td><p style = 'color: red'>*</p></td>
                        </tr>

                        <tr>
                            <td width="150"><label>Phone</label></td>
                            <td><input type="text" name="phone"></td>
                        </tr>

                        <tr>
                            <td width="150"><label>Password</label></td>
                            <td><input type="password" name="password"></td>
                            <td><p style = 'color: red'>*</p></td>
                        </tr>
                        
                        <tr>
                            <td width="150"></td>
                            <td><input type="submit" name="submit" value="Register"></td>
                        </tr>


                    </table>
                </form>
            </td>
        </tr>
    </table>
</div>
<body>
</html>


<?php include 'footer.php'; ?>