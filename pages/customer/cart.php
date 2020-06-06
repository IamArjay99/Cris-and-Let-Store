<?php
	include '../../include/db.php';
	include '../../function/function.php';
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
	                <a class="navbar-brand" href="index.php" id="id_title"> Cris & Let Store </a>
	            </div>

	            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	                <ul class="nav navbar-nav">
	                    <li><a href="index.php"> Home </a></li>
	                    <li><a href="../admin/index.php"> ADMINISTRATOR </a></li>
	                    <li><a> HI, GUEST </a></li>
	                    <li class="active"><a href="cart.php"> GO TO CART <span class="badge"><?php total_items(); ?></span></a></li>

	                </ul>
	                <form action="results.php" method="GET" class="navbar-form navbar-right">
	                    <div class="form-group label-floating">
	                        <label class="control-label">Search</label>
	                        <input type="text" name="user_query" class="form-control">
	                    </div>
	                    <button type="submit" name="search" class="btn btn-round btn-just-icon btn-success"><i class="material-icons">search</i><div class="ripple-container"></div></button>
	                </form>
	            </div>
	        </div>
	    </nav>
	    <!-- end of navbar -->

		<div class="container">
	    	<table class="table-striped table">
	    		<thead class="thead-inverse">
	    			<tr>
	    				<th>#</th>
	    				<th>Edit</th>
	    				<th colspan='2'>Product</th>
	    				<th>Quantity</th>
	    				<th>Price</th>
	    			</tr>
	    		</thead>
	    		<tbody>
	    			<form method="POST"> 
	    				<?php
	    					if (isset($_GET['product_id'])) {
	    						newAdded();
	    					echo "<div align='right'>
	    						<button name='update_cart' type='submit' class='btn btn-success'>Update</button>
	    						<button name='delete_cart' type='submit' class='btn btn-danger'>Delete</button>
	    					</div>";
	    					}
	    					else {
	    						if (isset($_GET['add_cart'])) {
	    						newAdded();
	    					echo "<div align='right'>
	    						<button name='update_cart' type='submit' class='btn btn-success'>Update</button>
	    						<button name='delete_cart' type='submit' class='btn btn-danger'>Delete</button>
	    					</div>";
	    						}
	    						else {
	    						mycart();
	    					echo "<div align='right'>
	    						<button name='delete_cart' type='submit' class='btn btn-danger'>Delete</button>
	    					</div>";
	    						}
	    					}
	    				?>
	    			</form>
	    		</tbody>
	    	</table>
	    </div>

	    <?php 
	    	if (!isset($_GET['add_cart'])) {
	    		echo '<div class="container" align="right" >
	    			<h3><a style="text-decoration:none" href="checkout.php">CHECKOUT</a></h3>
        		</div>';
	    	}
	    ?>

        <?php
        	//$ip = getIpAdd();

        	if (isset($_POST['delete_cart'])) {
        		if (isset($_POST['remove'])) {
        			foreach ($_POST['remove'] as $remove_id) {
        				$delete_items = "DELETE FROM cart WHERE product_id = '$remove_id'";
        				$run_delete = mysqli_query($conn, $delete_items);
        				if ($run_delete) {
        					header("Refresh:0.5; URL=cart.php");
        				}
        			}
        		}	
        	}
        	if (isset($_POST['update_cart'])) {
        		if (isset($_POST['remove'])) {
        			foreach ($_POST['remove'] as $update_id) {
        				$newQuantity = $_POST['update_quantity'];
        				$update_items = "UPDATE cart SET quantity='$newQuantity' WHERE product_id IN (SELECT id FROM products WHERE id='$update_id')";
	        			$run_update = mysqli_query($conn, $update_items);
	        			if ($run_update) {
	        				header("Location: index.php");
	        				//echo "Updated successfully";
	        			}
        			}
        		}	
        	}
        ?>

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

	    <!--<script src="../js/jquery.js"></script>
	    <script src="../js/proper.js"></script>
	    <script src="../js/javascript.js"></script>-->
	</body>
</html>