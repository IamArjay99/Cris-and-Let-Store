<?php
	include '../../include/db.php';
    session_start();

    if (isset($_SESSION['admin_fname'])) {
        $session_user = $_SESSION['admin_fname'];
    }
    else {
        header("Location: index.php");
    }
    if (isset($_GET['admin_fname'])) {
        $fname = $_GET['admin_fname'];
        if (isset($_GET['save'])) {
            $lname = $_GET['admin_lname'];
            $email = $_GET['admin_email'];
            $phone = $_GET['admin_number'];
            $new_pass = $_GET['new_password'];
            $confirm_pass = $_GET['confirm_password'];
            $old_pass = $_GET['old_password'];
            //$old_password = '';

            $select_pass = "SELECT * FROM admin WHERE admin_fname = '$fname'";
            $query_pass = mysqli_query($conn, $select_pass);
            while ($row = mysqli_fetch_assoc($query_pass)) {
                $old_password = $row['admin_password'];
            }
            if ($old_pass === $old_password) {
                if ($new_pass == $confirm_pass) {
                    $new_password = $confirm_pass;
                    $update_admin = "UPDATE admin SET admin_email = '$email', admin_number = '$phone', admin_password = '$new_password', admin_lname = '$lname' WHERE admin_fname = '$fname'";
                    $query_update = mysqli_query($conn, $update_admin);
                    if ($query_update) {
                        header("Location: profile.php");
                    }
                }
                else {
                    header("Location: update_profile.php");
                }
            }
            else {
                header("Location: update_profile.php");
            }
        }
    }
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> Cris & Let Inventory and Sales System </title>
        <link rel="stylesheet" href="../../css/vendor.css">
        <!-- Theme initialization -->
        <link rel="stylesheet" href="../../css/app-blue.css">
	</head>
	<body>
		 <div class="main-wrapper">
            <div class="app" id="app">
                <header class="header">
                    <div class="header-block header-block-collapse d-lg-none d-xl-none">
                        <button class="collapse-btn" id="sidebar-collapse-btn">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>
                    <div class="header-block header-block-search">
                        <form role="search" method="GET" action="result.php">
                            <div class="input-container">
                                <i class="fa fa-search"></i>
                                <input type="search" name="search_query" placeholder="Search">
                                <div class="underline"></div>
                            </div>
                        </form>
                    </div>
                    <div class="header-block header-block-nav">
                        <ul class="nav-profile">
                            <li class="notifications new">
                                <a href="" data-toggle="dropdown">
                                    <i class="fa fa-bell-o"></i>
                                    <sup>
                                        <span class="counter">
                                            <?php
                                                $get_products = "SELECT * FROM products";
                                                $query = mysqli_query($conn, $get_products);
                                                while ($row = mysqli_fetch_assoc($query)) {
                                                    $stocks = $row['product_stocks'];
                                                    $product_id = $row['id'];
                                                    if ($stocks < 10) {
                                                        $sql = "SELECT * FROM stocks WHERE product_id = '$product_id'";
                                                        $rsc = mysqli_query($conn, $sql);
                                                        if ($rsc) {
                                                            $upd = "UPDATE stocks SET product_stocks = '$stocks', status = 'unread' WHERE product_id = '$product_id'";
                                                            mysqli_query($conn, $upd);
                                                        }
                                                    }
                                                }

                                                $notif = "SELECT * FROM stocks WHERE status='unread'";
                                                $sql = mysqli_query($conn, $notif);
                                                $sql_c = mysqli_num_rows($sql);

                                                $get_cart = "SELECT * FROM temp_cart WHERE status = 'unread'";
                                                $result = mysqli_query($conn, $get_cart);
                                                $count = mysqli_num_rows($result);

                                                $total_notif = $sql_c + $count;

                                                if (($count > 0) OR ($sql_c > 0)) {
                                                    echo $total_notif;
                                                }                                            
                                            ?>
                                        </span>
                                    </sup>
                                </a>
                                <div class="dropdown-menu notifications-dropdown-menu">
                                    <ul class="notifications-container">
                                        <?php
                                            $sel = "SELECT * FROM stocks WHERE status = 'unread' ORDER BY 'date_' DESC LIMIT 5";
                                            $res_sel = mysqli_query($conn, $sel);
                                            $cnt_sel = mysqli_num_rows($res_sel);
                                            if ($cnt_sel > 0) {
                                                while ($rw = mysqli_fetch_array($res_sel)) {
                                                    echo "<li>
                                                        <a href='products.php?id=". $rw['product_id'] ."' class='notification-item'>
                                                            <div class='img-col'>
                                                                <div class='img'><i class='fa fa-warning fa-2x'></i></div>
                                                            </div>
                                                            <div class='body-col'>
                                                                <p style='";
                                                                        if ($rw['status'] == 'unread') {
                                                                            echo 'font-weight:bold';
                                                                        }
                                                    echo "'>Stocks Alert!<br>The stocks for ";

                                                    $sl = "SELECT * FROM products WHERE id = '$rw[product_id]' ORDER BY id DESC LIMIT 5";
                                                    $rs = mysqli_query($conn, $sl);
                                                    while ($rws = mysqli_fetch_array($rs)) {
                                                        echo $rws['product_name'];
                                                    }

                                                    echo " is now at ". $rw['product_stocks'] ."</p><br>
                                                                <small><i>" . date('F j, Y, g:i a',strtotime($rw['date_'])) . "</i></small>
                                                            </div>
                                                        </a>
                                                    </li>";
                                                }
                                            }

                                            $get_cart = "SELECT * FROM temp_cart WHERE status = 'unread' ORDER BY 'date_' DESC LIMIT 5";
                                            $result = mysqli_query($conn, $get_cart);
                                            $count = mysqli_num_rows($result);
                                            if ($count > 0) {
                                                while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                        <li>
                                            <a href="order.php?customer_tr_no=<?php echo $row['customer_tr_no'];?>" class="notification-item">
                                                <div class="img-col">
                                                    <div class="img"><i class="fa fa-shopping-cart fa-2x"></i></div>
                                                </div>
                                                <div class="body-col">
                                                    <p style="
                                                    <?php
                                                        if ($row['status'] == 'unread') {
                                                            echo 'font-weight:bold';
                                                        }

                                                    ?>">New order from <?php echo $row['customer_name']; ?><br>
                                                        <?php
                                                            $customer_name = $row['customer_name'];
                                                            $product_id = $row['product_id'];

                                                            $select = "SELECT * FROM products WHERE id IN (SELECT product_id FROM temp_cart WHERE customer_name = '$customer_name' AND product_id = '$product_id')";
                                                            $rst = mysqli_query($conn, $select);
                                                            //$count_ = mysqli_num_rows($result);
                                                            if ($rowss = mysqli_fetch_array($rst)) {
                                                                echo $rowss['product_type'] . " : " . $rowss['product_name'] . "<br> Quantity: " . $row['quantity'];
                                                            }
                                                            echo "<br><small><i>" . date('F j, Y, g:i a',strtotime($row['date_'])) . "</i></small>";
                                                        ?>
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                        <?php
                                                }
                                            }
                                        
                                        ?>
                                    </ul>
                                    <footer>
                                        <ul>
                                            <li>
                                                <a href="notification.php"> View All </a>
                                            </li>
                                        </ul>
                                    </footer>
                                </div>
                            </li>
                            <li class="profile dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    <div class="img" style="background-image: url('../../assets/images/profile-default.png')"> </div>
                                    <span class="name"> <?php echo $session_user; ?> </span>
                                </a>
                                <div class="dropdown-menu profile-dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <a class="dropdown-item" href="profile.php">
                                        <i class="fa fa-user icon"></i> Profile </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="logout.php">
                                        <i class="fa fa-power-off icon"></i> Logout </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </header>
                <aside class="sidebar">
                    <div class="sidebar-container">
                        <div class="sidebar-header">
                            <div class="brand">
                             <span style='font-family:georgia'>ADMINISTRATOR</span> 
                            </div>
                        </div>
                        <nav class="menu">
                            <ul class="sidebar-menu metismenu" id="sidebar-menu">
                                <li>
                                    <a href="dashboard.php">
                                        <i class="fa fa-home"></i> Dashboard 
                                    </a>
                                </li>
                                <li>
                                    <a href="products.php">
                                        <i class="fa fa-beer"></i> Products
                                    </a>
                                </li>
                                <li>
                                    <a href="add.php">
                                        <i class="fa fa-plus-square"></i> Add
                                    </a>
                                </li>
                                <li>
                                    <a href="order.php">
                                        <i class="fa fa-shopping-cart"></i> Order
                                    </a>
                                </li>
                                <li>
                                    <a href="transaction.php">
                                        <i class="fa fa-credit-card"></i> Sales 
                                    </a>
                                </li>
                                <li>
                                    <a href="customers.php">
                                        <i class="fa fa-users"></i> Customers 
                                    </a>
                                </li>
                                <li>
                                    <a href="notification.php">
                                        <i class="fa fa-bell"></i> Notification 
                                    </a>
                                </li>
                                <li class='active'>
                                    <a href="profile.php">
                                        <i class="fa fa-user"></i> Profile 
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </aside>

                <article class="content dashboard-page">
                    <div class="title-block">
                        <h3 class="title"> Cris & Let Inventory and Sales System </h3>
                        <p class="title-description"> Profile </p>
                    </div>
                    <section class="section">
                        <div class="row sameheight-container">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="../../assets/images/profile-default.png">
                                </div>
                                <div class="col-md-8">
                                    <?php
                                        $select_user = "SELECT * FROM admin WHERE admin_fname = '$session_user'";
                                        $query_user = mysqli_query($conn, $select_user);
                                        if ($query_user) {
                                            while ($user = mysqli_fetch_assoc($query_user)) {
                                    ?>
                                    <form method="GET" style="margin-left: 10px">
                                        <div class="form-group">
                                            <h4>FIRST NAME: <i><small><input type="text" style='text-decoration: none; border:none; background-color: rgba(0,0,0,0); font-family: georgia; padding-left: 5px; color:black' name="admin_fname" value="<?php echo $user['admin_fname'] ?>" readonly></small></i></h4>
                                        </div>
                                        <div class="form-group">
                                            <h4>LAST NAME: <i><small><input type="text" style='text-decoration: none; border:none; background-color: rgba(0,0,0,0); font-family: georgia; padding-left: 5px; color:brown' name="admin_lname" value="<?php echo $user['admin_lname'] ?>" required></small></i></h4>
                                        </div>
                                        <div class="form-group">
                                            <h4>EMAIL ADDRESS: <i><small><input type="text" style='text-decoration: none; border:none; background-color: rgba(0,0,0,0); font-family: georgia; padding-left: 5px; color:brown' name="admin_email" value="<?php echo $user['admin_email'] ?>" required></small></i></h4>
                                        </div>
                                        <div class="form-group">
                                            <h4>CONTACT NUMBER: <i><small><input type="text" style='text-decoration: none; border:none; background-color: rgba(0,0,0,0); font-family: georgia; padding-left: 5px; color:brown' name="admin_number" value="<?php echo $user['admin_number'] ?>" required></small></i></h4>
                                        </div>
                                        <div class="form-group">
                                            <h4>NEW PASSWORD: <i><small><input type="password" style='text-decoration: none; border:none; background-color: rgba(0,0,0,0); font-family: georgia; padding-left: 5px; color:brown' name="new_password" required></small></i></h4>
                                        </div>
                                        <div class="form-group">
                                            <h4>CONFIRM PASSWORD: <i><small><input type="password" style='text-decoration: none; border:none; background-color: rgba(0,0,0,0); font-family: georgia; padding-left: 5px; color:brown' name="confirm_password" required></small></i></h4>
                                        </div>
                                        <div class="form-group">
                                            <h4>OLD PASSWORD: <i><small><input type="password" style='text-decoration: none; border:none; background-color: rgba(0,0,0,0); font-family: georgia; padding-left: 5px; color:brown' name="old_password" required></small></i></h4>
                                        </div>
                                        <div class="form-group" align="right">
                                            <input type="submit" onclick="Javascript: return confirm('Do you want to update your profile?')" class="btn btn-success mt-4" name="save" value="SAVE">
                                            <a href='profile.php' onclick="Javascript: return confirm('Are you sure?')" class="btn btn-danger mt-4" name="cancel_profile">CANCEL</a>
                                        </div>
                                    </form>
                                    <?php
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </section>
                </article>
            </div>
        </div>

        <script src="../../js/vendor.js"></script>
        <script src="../../js/app.js"></script>

	</body>

</html>
