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

    <?php
        $msg = $alert = '';
        if (isset($_POST['product_submit'])) {
            $product_name = $_POST['product_name'];
            $product_description = $_POST['product_description'];
            $product_type = $_POST['product_type'];
            $product_size_number = $_POST['product_size_number'];
            $product_size = $_POST['product_size'];
            //$product_cover = $_POST['product_cover'];
            $product_stocks = $_POST['product_stocks'];
            $product_price = $_POST['product_price'];

            $fileName = $_FILES['product_cover']['name'];
            $fileTmpName = $_FILES['product_cover']['tmp_name'];
            $fileSize = $_FILES['product_cover']['size'];
            $fileError = $_FILES['product_cover']['error'];
            $fileType = $_FILES['product_cover']['type'];

            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));
            $allowed = array('jpg', 'jpeg', 'png'); 

            if (in_array($fileActualExt, $allowed)) {
                if ($fileError === 0) {
                    if ($fileSize < 1000000) {
                        $product_cover = uniqid('', true) . "." . $fileActualExt;
                        $fileDestination = '../../images/' . $product_cover;
                        move_uploaded_file($fileTmpName, $fileDestination);

                        $insert_product = "INSERT INTO products (product_name, product_description, product_type, product_size_number, product_size, product_cover, product_stocks, product_price) VALUES ('$product_name', '$product_description', '$product_type','$product_size_number','$product_size', '$product_cover','$product_stocks', '$product_price')";
                        $insert_query = mysqli_query($conn, $insert_product);

                        if ($insert_query) {
                            $sel = "SELECT * FROM products WHERE product_name = '$product_name'";
                            $qry = mysqli_query($conn, $sel);
                            if (mysqli_num_rows($qry) > 0) {
                                while ($rw = mysqli_fetch_array($qry)) {
                                    $product_id = $rw['id'];
                                    $ins = "INSERT INTO stocks SET product_id = '$product_id', product_stocks = '$product_stocks'";
                                    $if = mysqli_query($conn, $ins);
                                    if ($if) {
                                        $msg = "";
                                        $alert = "<div class='alert alert-success' role='alert'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                                <span aria-hidden='true'>&times;</span>
                                            </button>
                                            <strong class='text-center'>Added Successfully</strong>
                                        </div>";
                                    }
                                }
                            }
                            //header("Location: dashboard.php");
                        }
                    }
                    else {
                        $msg = "Your file is too big";
                        $alert = '';
                    }
                }
                else {
                    $msg = "There was an error uploading your file";
                    $alert = '';
                }
            }
            else {
                $msg = "You can't upload files of this type";
                $alert = '';
            }

        }
    ?>

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
                                <li class='active'>
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
                        <p class="title-description"> Add </p>
                    </div>
                    <section class="section">
                        <div class="card card-block sameheight-item">
                            <div class="row">
                                <div class="col-md-12">
                                    <span><?php echo $msg; echo $alert; ?></span>
                                    <form role="form" method="POST" enctype="multipart/form-data">
                                        <div class="title-block">
                                            <label class="control-label"> Name </label>
                                            <input type="text" class="form-control underlined" name='product_name' required>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"> Description </label>
                                            <textarea type="text" class="form-control underlined" name='product_description' rows='5' style='resize:none' required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"> Type </label>
                                            <select class="form-control" name="product_type" required>
                                                <option value="Water" default> Water </option>
                                                <option value="Milk"> Milk </option>
                                                <option value="Softdrinks"> Softdrinks </option>
                                                <option value="Juice"> Juice </option>
                                                <option value="Beer"> Beer </option>
                                                <option value="Wine"> Wine </option>
                                            </select>
                                        </div>
                                        <div class="form-group form-inline">
                                            <label class="control-label"> Size  </label>
                                            <input type="number" step="0.1" class="form-control underlined ml-4 text-right" name='product_size_number' required>
                                            <select class="form-control ml-2" name="product_size" required>
                                                <option value="oz" default>oz</option>
                                                <option value="ml">ml</option>
                                                <option value="L">L</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"> Cover </label><br>
                                            <input type="file" name="product_cover" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"> Stocks </label>
                                            <input type="text" class="form-control underlined" name='product_stocks' required>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"> Price </label>
                                            <input type="text" class="form-control underlined" placeholder='₱' name='product_price' required>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" name='product_submit' value="Submit" class="form-control btn btn-primary btn-lg btn-block">
                                        </div>
                                    </form>
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
