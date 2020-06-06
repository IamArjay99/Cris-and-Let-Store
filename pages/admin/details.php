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
                                <li class='active'>
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
                        <p class="title-description"> Products </p>
                    </div>
                    <section class="section">
                        <div class="row sameheight-container">
                            <div class="col col-12 col-sm-12 col-md-6 col-xl-6 stats-col">
                                <?php
                                    if (isset($_GET['id'])) {
                                        $product_name = $product_description ='';
                                        $id = $_GET['id'];
                                        $sid = "SELECT * FROM products WHERE id = '$id'";
                                        $qid = mysqli_query($conn, $sid);
                                        while ($rid = mysqli_fetch_assoc($qid)) {
                                            $product_name = $rid['product_name'];
                                            $product_description = $rid['product_description'];
                                            $product_type = $rid['product_type'];
                                            $product_size = $rid['product_size_number'].''.$rid['product_size'];
                                            $product_stocks = $rid['product_stocks'];
                                            $product_price = $rid['product_price'];
                                            $time_added = $rid['time_added'];
                                        }
                                    }
                                ?>
                                <table class="table table-hover table-striped table-bordered">
                                    <tr>
                                        <th> Product Name </th>
                                        <td> <?php echo $product_name; ?> </td>
                                    </tr>
                                    <tr>
                                        <th> Description </th>
                                        <td> <?php echo $product_description; ?> </td>
                                    </tr>
                                    <tr>
                                        <th> Type </th>
                                        <td> <?php echo $product_type; ?> </td>
                                    </tr>
                                    <tr>
                                        <th> Size </th>
                                        <td> <?php echo $product_size; ?> </td>
                                    </tr>
                                    <tr>
                                        <th> Available Stocks </th>
                                        <td> <?php echo $product_stocks; ?> </td>
                                    </tr>
                                    <tr>
                                        <th> Price </th>
                                        <td> <?php echo "₱".$product_price; ?> </td>
                                    </tr>
                                    <tr>
                                        <th> Time Added </th>
                                        <td> <?php echo date('F j, Y, g:i a', strtotime($time_added)); ?> </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col col-12 col-sm-12 col-md-6 col-xl-6 stats-col">
                                <table class="table table-bordered text-center">
                                    <thead>
                                    <tr>
                                        <th colspan="2"> Stocks History </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th> Date </th>
                                            <th> Stocks </th>
                                        </tr>
                                        <?php
                                            $sle = "SELECT * FROM stocks WHERE product_id = $id";
                                            $qsle = mysqli_query($conn, $sle);
                                            if ($qsle) {
                                                while ($wor = mysqli_fetch_assoc($qsle)) {
                                        ?>
                                        <tr>
                                            <td> <?php echo date('F j, Y g:i A', strtotime($wor['date_'])); ?> </td>
                                            <td> <?php echo $wor['product_stocks']; ?> </td>
                                        </tr>
                                        <?php        
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div><br>
                        <div class="row sameheight-container">
                            <div class="col col-12 col-sm-12 col-md-12 col-xl-12 stats-col">
                                <table class="table table-hover table-striped table-bordered">
                                    <tr>
                                        <th> Total Items </th>
                                        <td> <?php 
                                            $total_items = $total_qty = $final_total_items = 0;
                                            $sl = "SELECT * FROM temp_cart WHERE product_id = '$id'";
                                            $qsl = mysqli_query($conn, $sl);
                                            while ($r = mysqli_fetch_assoc($qsl)) {
                                                $total_qty = $total_qty + $r['quantity'];
                                            }
                                            $sl2 = "SELECT * FROM stocks WHERE product_id = '$id'";
                                            $qsl2 = mysqli_query($conn, $sl2);
                                            while ($r2 = mysqli_fetch_assoc($qsl2)) {
                                                $total_items = $r2['product_stocks'];
                                            }
                                            $final_total_items = $total_qty + $total_items;
                                            echo $final_total_items;
                                        ?> </td>
                                    </tr>
                                    <tr>
                                        <th> Total Sold </th>
                                        <td> <?php
                                            $total_qty = 0;
                                            $sl = "SELECT * FROM temp_cart WHERE product_id = '$id'";
                                            $qsl = mysqli_query($conn, $sl);
                                            while ($r = mysqli_fetch_assoc($qsl)) {
                                                $total_qty = $total_qty + $r['quantity'];
                                            }
                                            echo $total_qty;
                                        ?> </td>
                                    </tr>
                                    <tr>
                                        <th> Total Income </th>
                                        <td> <?php echo "₱".$total_qty*$product_price; ?> </td>
                                    </tr>
                                    <tr>
                                        <th> Customer(s) </th>
                                        <td>
                                            <table class="table table-bordered text-center">
                                                <?php
                                                    $sl = "SELECT * FROM temp_cart WHERE product_id = '$id'";
                                                    $qsl = mysqli_query($conn, $sl);
                                                
                                                    if (mysqli_num_rows($qsl) > 0) {
                                                        echo "
                                                        <tr>
                                                            <th> Name </th>
                                                            <th> Quantity </th>
                                                            <th> Date </th>
                                                        </tr>";
                                                    while ($r = mysqli_fetch_assoc($qsl)) {
                                                        $cus = $r['customer_name'];
                                                        $qty = $r['quantity'];
                                                        $dt = $r['date_'];
                                                ?>
                                                <tr>
                                                    <td><?php echo $cus; ?></td>
                                                    <td><?php echo $qty; ?></td>
                                                    <td><?php echo date('F j, Y, g:i a', strtotime($dt)); ?></td>
                                                </tr>
                                                <?php }
                                                    }
                                                    else {
                                                        echo " - ";
                                                    }
                                                ?>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
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
