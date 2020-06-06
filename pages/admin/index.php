<?php
    include '../../include/db.php';
    session_start();
?>
<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title> Cris & Let Inventory and Sales System </title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Place favicon.ico in the root directory -->
        <link rel="stylesheet" href="../../css/vendor.css">
        <!-- Theme initialization -->
        <link rel="stylesheet" href="../../css/app-blue.css">
    </head>

    <?php
        if (isset($_GET['login'])) {
            $username = mysqli_real_escape_string($conn, $_GET['username']);
            $password = mysqli_real_escape_string($conn, $_GET['password']);

            $sql = "SELECT * FROM admin WHERE admin_email='$username' AND admin_password='$password'";

            $result = $conn->query($sql);

            if (!$row = $result->fetch_assoc()) {
                $msg = "Your username or password is incorrect!";
                echo "<script type='text/javascript'>alert('$msg')</script>";
            }
            else {
                $time_update = "UPDATE admin SET time_ = date('F j, Y, g:i a') WHERE admin_email = '$username' AND admin_password='$password'";
                $sql = mysqli_query($conn, $time_update);
                if ($sql) {
                    $_SESSION['admin_fname'] = $row['admin_fname'];
                    header("location: dashboard.php");
                }
            }
        }
    ?>

    <body>
        <div class="auth">
            <div class="auth-container">
                <div class="card">
                    <header class="auth-header">
                        <h1 class="auth-title" style='font-family:georgia'> ADMINISTRATOR </h1>
                    </header>
                    <div class="auth-content">
                        <p class="text-center">LOGIN TO CONTINUE</p>
                        <form id="login-form" method="GET" novalidate="">
                            <div class="form-group">
                                <label for="username">Email</label>
                                <input type="email" class="form-control underlined" name="username" id="username" placeholder="Your email" required> </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control underlined" name="password" id="password" placeholder="Your password" required> </div>
                            <div class="form-group">
                                <a href="forgot_password.php" class="forgot-btn pull-right mb-3">Forgot password?</a>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-primary" name='login'>Login</button>
                            </div>
                            <div class="form-group">
                                <p class="text-muted text-center">Do not have an account?
                                    <a href="signup.php">Sign Up!</a>
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
        <!-- Reference block for JS -->
        <div class="ref" id="ref">
            <div class="color-primary"></div>
            <div class="chart">
                <div class="color-primary"></div>
                <div class="color-secondary"></div>
            </div>
        </div>
        <script src="../../js/vendor.js"></script>
        <script src="../../js/app.js"></script>
    </body>
</html>