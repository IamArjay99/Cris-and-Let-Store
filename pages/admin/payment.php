<?php
	include '../../include/db.php';
    session_start();

    if (isset($_SESSION['admin_fname'])) {
        $session_user = $_SESSION['admin_fname'];
    }
    else {
        header("Location: index.php");
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
                                <li class='active'>
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
                                <li>
                                    <a href="adminlog.php">
                                        <i class="fa fa-group"></i> Admin Log 
                                    </a>
                                </li>
                                <li>
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
                        <p class="title-description"> Payment </p>
                    </div>
                    <section class="section">
                        <?php
                            if (isset($_GET['customer_tr_no'])) {
                                $customer_tr_no = $_GET['customer_tr_no'];

                                $get_profile = "SELECT * FROM customer WHERE customer_tr_no = '$customer_tr_no'";
                                $query_get_profile = mysqli_query($conn, $get_profile);
                                $count_get_profile = mysqli_num_rows($query_get_profile);
                                if ($count_get_profile > 0) {
                                    while ($profile = mysqli_fetch_array($query_get_profile)) {
                        ?>
                        <div class='row'>
                            <div class='col-md-4'>
                                <h3> PROFILE </h3><br>
                                <p><b>TRANSACTION NUMBER: </b><i><?php echo $profile['customer_tr_no']; ?></i></p><br>
                                <p><b>FULLNAME: </b><i><?php echo $profile['customer_name']; ?></i></p><br>
                                <p><b>EMAIL ADDRESS: </b><i><?php echo $profile['customer_email']; ?></i></p><br>
                                <p><b>PHONE NUMBER: </b><i><?php echo $profile['customer_number']; ?></i></p><br>
                                <p><b>ADDRESS: </b><i><?php echo $profile['customer_address']; ?></i></p><br>
                            </div>
                        <?php
                                    }
                                }
                        ?>
                            <div class="col-md-8">
                                <h3> ORDER </h3>
                                <table class='table table-bordered table-hover'>
                                    <thead class='thead-inverse'>
                                        <tr>
                                            <th> # </th>
                                            <th> Product </th>
                                            <th> Name </th>
                                            <th> Quantity </th>
                                            <th> Price </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                            <?php
                                $count = 1;
                                $total_cost = 0;

                                $get_cart = "SELECT * FROM temp_cart WHERE customer_tr_no = '$customer_tr_no'";
                                $query_get_cart = mysqli_query($conn, $get_cart);
                                $count_get_cart = mysqli_num_rows($query_get_cart);

                                if ($count_get_cart > 0) {
                                    while ($rows = mysqli_fetch_array($query_get_cart)) {
                                        $product_id = $rows['product_id'];
                                        $cost = $rows['cost'];
                                        $total_cost += $cost;

                            ?>
                                    <tr>
                                        <td><h3> <?php echo $count++; ?> </h3></td>
                                    <?php
                                        $get_info = "SELECT * FROM products WHERE id IN (SELECT product_id FROM temp_cart WHERE customer_tr_no = '$customer_tr_no' AND product_id = '$product_id')";
                                        $query_get_info = mysqli_query($conn, $get_info);
                                        while ($row = mysqli_fetch_array($query_get_info)) {
                                    ?>
                                        <td><img src='../../images/<?php echo $row['product_cover'] ?>' width='auto' height='80px'></td>
                                        <td><h3> <?php echo $row['product_name'] ?> </h3></td>
                        <?php
                                        }
                        ?>
                                        <td><h3> <?php echo $rows['quantity']; ?> </h3></td>
                                        <td><h3> ₱<?php echo $rows['price']; ?> </h3></td>
                                    </tr>
                        <?php
                                    }
                        ?>
                                    <tr><td colspan='6' align='right'><h3>Total: ₱ <?php echo $total_cost ?></h3></td></tr>
                        <?php
                                }
                            }
                        ?>
                                </tbody>
                                </table>
                                <form method='GET' action="run_payment.php?customer_tr_no=<?php echo $customer_tr_no?>">
                                    <div class="form-group">
                                        <label class="control-label"> Cash </label>
                                        <input type="number" class="form-control" placeholder='Enter cash (₱)' min='<?php echo $total_cost?>' name='cash' required>
                                    </div>
                                    <div class='form-group' align='right'>
                                        <button class='btn btn-success' name='customer_tr_no' value='<?php echo $customer_tr_no ?>'> PROCEED </button>
                                        <a href='run_notif.php?customer_tr_no=<?php echo $customer_tr_no ?>&status=unread' onclick="Javascript: return confirm('Do you want to cancel this order?')"class='btn btn-danger'>CANCEL ORDER</a>
                                    </div>
                                </form>
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
