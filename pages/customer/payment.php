<?php
	include '../../include/db.php';
	include '../../function/function.php';
	session_start();
	if (isset($_SESSION['customer_tr_no'])) {
        $session_user = $_SESSION['customer_tr_no'];
    }
    else {
        header("Location: checkout.php");
    }
?>
<!DOCTYPE>
<html lang="en">
	<head>
		<meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title> Cris & Let Inventory and Sales System </title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Book-store-master -->
		<link href="../../assets/css/bootstrap.min.css" rel="stylesheet" />
    	<link href="../../assets/css/material-kit.css" rel="stylesheet" />
    	<link href="../../assets/css/styles.css" rel="stylesheet" />
	</head>
	<body>
		<nav class="navbar navbar-fixed-top" role="navigation" id="topnav">
	 	   <div class="container-fluid">
	            <div class="navbar-header">
	                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	                <span class="sr-only">Toggle navigation</span>
	                <span class="icon-bar"></span>
	                <span class="icon-bar"></span>
	                <span class="icon-bar"></span>
	    		</button>
	                <a class="navbar-brand" id="id_title"> Cris & Let Store </a>
	            </div>

	            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	                <ul class="nav navbar-nav">
	                    <li><a>Home</a></li>
	                    <li><a href="logout.php">Buy again</a></li>
	                    <li><a>HI, <?php 
	                    	$get_user = "SELECT * FROM customer WHERE customer_tr_no = '$session_user'";
	                    	$query_getuser = mysqli_query($conn, $get_user);
	                    	if (mysqli_num_rows($query_getuser) > 0) {
	                    		if ($user = mysqli_fetch_assoc($query_getuser)) {
	                    			echo $user['customer_name'];
	                    		}
	                    	}
	                    ?></a></li>
	                    <li class="active"><a>GO TO CART <span class="badge"><?php total_items(); ?></span></a></li>
	                </ul>
	            </div>
	        </div>
	    </nav>
	    <!-- end of navbar -->
	    <div class='container'>
		    <div class="row">
		    	<div class="col-md-1"></div>
		    	<div class="col-md-10">
		    		<h3>Summary of your order:</h3>
		    		<table class='table table-inverse'>
		    			<thead class="thead-inverse">
			    			<tr>
			    				<th>#</th>
			    				<th colspan='2'>Product</th>
			    				<th>Quantity</th>
			    				<th>Price</th>
			    			</tr>
		    			</thead>
		    			<tbody>
		    				<?php mycart_payment() ?>
		    				<h4>Download your <a href="../../receipt/receipt.php" target="_blank">receipt here!</a></h4>
		    			</tbody>
		    		</table>
		    	</div>
		    	<div class="col-md-1"></div>
		    </div>
	    </div>

        <!--   Core JS Files   -->
		<script src="../../assets/js/jquery.min.js" type="text/javascript"></script>
		<script src="../../assets/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="../../assets/js/material.min.js"></script>

		<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
		<script src="../../assets/js/nouislider.min.js" type="text/javascript"></script>

		<!--  Plugin for the Datepicker, full documentation here: http://www.eyecon.ro/bootstrap-datepicker/ -->
		<script src="../../assets/js/bootstrap-datepicker.js" type="text/javascript"></script>

		<!-- Control Center for Material Kit: activating the ripples, parallax effects, scripts from the example pages etc -->
		<script src="../../assets/js/material-kit.js" type="text/javascript"></script>
		<script src="../../assets/js/carousel.js" type="text/javascript"></script>
		<script src="../../assets/js/myscripts.js" type="text/javascript"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
	
		<?php

			$conn = mysqli_connect("localhost", "root", "", "inventory_system");

			function mycart_payment() {
				global $conn;
				$session_user = $_SESSION['customer_tr_no'];
				$customer_name = $mode_of_payment = '';

				$get_user = "SELECT * FROM customer WHERE customer_tr_no = '$session_user'";
	            $query_getuser = mysqli_query($conn, $get_user);
	            if (mysqli_num_rows($query_getuser) > 0) {
	            	if ($user = mysqli_fetch_assoc($query_getuser)) {
	              		$customer_name = $user['customer_name'];
	              		$mode_of_payment = $user['mode_of_payment'];
	             	}
	            }

				//$ip = getIpAdd();
				$getcart = "SELECT * FROM products WHERE id IN (SELECT product_id FROM cart)";
				$cart_items = mysqli_query($conn, $getcart);
				$total_price = 0;
				$count = 1;
				$total_quantity = 0;

				while ($rows = mysqli_fetch_array($cart_items)) {
					$price_arr = array($rows['product_price']);
					$single_price = $rows['product_price'];
					$product_name = $rows['product_name'];
					$product_id = $rows['id'];
					$product_stocks = $rows['product_stocks'];

					echo "<tr>
						<td scope='row'><h3>". $count++ ."</h3></td>
						<td><img src='../../images/". $rows['product_cover'] ."' width='50px' height='80px'></td>
						<td><h3>". $product_name ."</h3></td>
						<td><h3>";

					$sql = "SELECT * FROM cart WHERE product_id ='$product_id'";
					$result = mysqli_query($conn, $sql);

					while ($row = mysqli_fetch_array($result)) {
						$quantity = $row['quantity'];
						echo $row['quantity'];
						$cost = $quantity * $single_price;
						$insert_tempcart = "INSERT INTO temp_cart (customer_tr_no, customer_name, product_id, quantity, price, cost, status, mode_of_payment, status_of_order) 
						VALUES ('$session_user', '$customer_name', '$product_id', '$quantity', '$single_price', '$cost', 'unread', '$mode_of_payment', 'Pending') ";
						$rs1 = mysqli_query($conn, $insert_tempcart);

						/*$update_stocks = $book_stocks - $quantity;
						$update_stocks = "UPDATE book_info SET book_stocks = '$update_stocks' WHERE id = '$book_id'";
						mysqli_query($conn, $update_stocks);*/
					}
					$total_quantity += $quantity;
					$total_qty = $quantity * $single_price;
					$newQuantity = $quantity;
					$newTotal_qty = $total_qty;
					$total_price += $newTotal_qty;

					echo "</h3></td>
						<td><h3> ₱". $single_price ."</h3></td>
					</tr>";
				}
				echo "<tr><td colspan='6' align='right'><h3>TOTAL: ₱". $total_price ."</h3></td>";
				//echo "<td>" . $total_quantity . "</td></tr>";

			}
		?>

	</body>
</html>