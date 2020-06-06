<?php
    include '../../include/db.php';
?>
<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title> Cris & Let Inventory and Sales System </title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../../css/vendor.css">
        <!-- Theme initialization -->
        <link rel="stylesheet" href="../../css/app-blue.css">
    </head>

    <body>
        <div class="auth">
            <div class="auth-container">
                <div class="card">
                    <header class="auth-header">
                        <h1 class="auth-title"> Administrator </h1>
                    </header>
                    <div class="auth-content">
                        <p class="text-center">PASSWORD RECOVER</p>
                        <p class="text-muted text-center">
                            <small>Enter your email address to recover your password.</small>
                        </p>
                        <form id="reset-form" method="GET" novalidate="">
                            <div class="form-group">
                                <label for="email1">Email</label>
                                <input type="email" class="form-control underlined" name="email1" id="email1" placeholder="Your email address" required> 
                            </div>
                            <div class="form-group">
                                 <label for="phone">Phone Number</label>
                                 <input type="number" class="form-control underlined" name="phone" id="phone" class='phone' placeholder="Your phone number" required>
                            </div>
                            <div class="form-group">
                                <input type="submit" name='form-forgot' class="btn btn-block btn-danger" value='Reset'>
                            </div>
                            <div class="form-group clearfix">
                                <a class="pull-left" href="index.php">return to Login</a>
                                <a class="pull-right" href="signup.php">Sign Up!</a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center">
                    <a href="../customer/index.php" class="btn btn-secondary btn-sm">
                        <i class="fa fa-arrow-left"></i> Back to dashboard </a>
                </div>
            </div>
        </div>

        <?php
        if (isset($_GET['form-forgot'])) {
            $email = $_GET['email1'];
            $phone = $_GET['phone'];

            $get_frdb = "SELECT * FROM admin";
            $query_result = mysqli_query($conn, $get_frdb);

            while ($row = mysqli_fetch_assoc($query_result)) {
                $admin_email = $row['admin_email'];
                $admin_number = $row['admin_number'];

                if (($admin_email==$email)&&($admin_number==$phone)) {
                    echo "<script>window.open('recover.php?admin_email=$email', '_SELF')</script>";
                }
            }
            $error_msg = "Incorrect email or phone number";
            echo "<script>alert('$error_msg');</script>";
        }
        ?>

        <script src="../../js/vendor.js"></script>
        <script src="../../js/app.js"></script>
    </body>
</html>