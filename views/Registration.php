<?php
include '../config/helpers.php';
include 'header.php';
?>

<div class="auth-form" style="max-width: 500px; margin: 20px auto;">
    <table class="layout-table">
        <tr>
            <td style="background: #eeeeee;"><h2>Register</h2></td>
        </tr>
        <tr>
            <td>
                <form action="../controllers/RegisterController.php" method="POST">
                    <table class="form-table">
                        
                        <tr>
                            <td width="150"><label>Name</label></td>
                            <td><input type="text" name="name" required></td>
                        </tr>
                        <tr>
                            <td><label>Email</label></td>
                            <td><input type="email" name="email" required></td>
                        </tr>
                        <tr>
                            <td><label>Phone (Optional)</label></td>
                            <td><input type="text" name="phone"></td>
                        </tr>
                        <tr>
                            <td><label>Password</label></td>
                            <td><input type="password" name="password" required minlength="8"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><button type="submit" class="btn">Register</button></td>
                        </tr>     
                                

                        
                     </table>
                </form>
            </td>
        </tr>
  </table>
</div>

<?php include 'footer.php'; ?>