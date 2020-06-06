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
                        <p class="text-center">SIGN UP</p>
                        <form id="signup-form" method="POST" novalidate="">
                            <div class="form-group">
                                <label for="firstname">Name</label>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control underlined" name="firstname" id="firstname" placeholder="Enter firstname" required=""> </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control underlined" name="lastname" id="lastname" placeholder="Enter lastname" required=""> </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control underlined" name="email" id="email" placeholder="Enter email address" required=""> </div>
                            <div class="form-group">
                                 <label for="phone">Phone Number</label>
                                 <input type="number" class="form-control underlined" name="phone" id="phone" class='phone' placeholder="Your phone number" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control underlined" name="password" id="password" placeholder="Enter password" required=""> </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control underlined" name="retype_password" id="retype_password" placeholder="Re-type password" required=""> </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-primary" name='update'>Sign Up</button>
                            </div>
                            <div class="form-group">
                                <p class="text-muted text-center">Already have an account?
                                    <a href="index.php">Login!</a>
                                </p>
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
            if (isset($_POST['update'])) {
                $fname = $_POST['firstname'];
                $lname = $_POST['lastname'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $password = $_POST['password'];

                $ins = "INSERT INTO admin (admin_fname, admin_lname, admin_email, admin_number, admin_password) 
                VALUES ('$fname', '$lname', '$email', '$phone', '$password')";

                $rs_ins = mysqli_query($conn, $ins);
                if ($rs_ins) {
                    header("Location: index.php");
                }
            }
        ?>

        <script src="../../js/vendor.js"></script>
        <script src="../../js/app.js"></script>
    </body>
</html>