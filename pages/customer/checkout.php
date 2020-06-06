<?php
	include '../../include/db.php';
	include '../../function/function.php';
	session_start();
?>
<!DOCTYPE>
<html lang="en">
	<head>
		<meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title> Cris & Let Inventory and Sales System </title>
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700|Raleway:300,600" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">
	  	<link href="../../assets/css/bootstrap.min.css" rel="stylesheet" />
    	<link href="../../assets/css/material-kit.css" rel="stylesheet" />
	  	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
	  	<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>
	  	<link rel="stylesheet" href="styles.css">
	  	<link rel="stylesheet" href="../../assets/css/styles.css">
	</head>
	<body style="margin-top:0px">
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
	                </ul>
	            </div>
	        </div>
	    </nav>
	    <!-- end of navbar -->

	    <?php 
		    $error = '';

		     $get_items="SELECT * FROM cart";
		     $run=mysqli_query($conn, $get_items);
		     $check_cart = mysqli_num_rows($run);
		   if($check_cart==0){
		     //$_SESSION['email']=$c_email;
		     echo "<script>window.open('index.php','_self')</script>";
		   }
		   else {
		   		if(isset($_POST['submit'])){
		        //$ip = getIpAdd();
		        $c_name = $_POST['fullname'];
		        $c_email = $_POST['emailAdress'];
		        $c_phone = $_POST['phone'];
		        $c_address = $_POST['address'];
		        $c_payment = $_POST['modee'];

		         
			    $temp_customer_no = $last = 0;
			    $get_num = 'SELECT id FROM customer';
			    $query_getnum = mysqli_query($conn, $get_num);
			    $count_getnum = mysqli_num_rows($query_getnum);
			    if ($count_getnum > 0) {
			    	$get_num2 = 'SELECT * FROM customer';
					$query_getnum2 = mysqli_query($conn, $get_num2);
					while ($rsz = mysqli_fetch_assoc($query_getnum2)) {
						$last = $rsz['customer_tr_no'];
					}
					$temp_customer_no = $last + 1;
			    }
			    else {
			    	$temp_customer_no = 190000;
			    }
			                    
			    //echo $temp_customer_no;
		        $c_tr_no = $temp_customer_no;

		        $check = "SELECT * FROM customer";
		        $rs_check = mysqli_query($conn, $check);
		        if ($rs_check) {
		            $query = "INSERT INTO customer (customer_tr_no, customer_name, customer_email, customer_number, customer_address, mode_of_payment) 
		            VALUES ('$c_tr_no','$c_name', '$c_email', '$c_phone', '$c_address', '$c_payment')";
		            $result = mysqli_query($conn, $query);
		            if($result){
		            	$_SESSION['customer_tr_no']=$c_tr_no;
		     			$session_user = $_SESSION['customer_tr_no'];
		              
		     			echo "<script>window.open('payment.php','_self')</script>"; 
		          }
		        }
		    }
		   }
		  ?>

		<div class="container">
	    	<section id="formHolder">
			    <div class="row">

			        <!-- Brand Box -->
			         <div class="col-sm-6 brand">

			            <div class="heading">
			               <h2> Cris <br> & <br> Let </h2>
			               <h2> Store </h2><hr>
			               <p> 1891 Recto Ave, Sampaloc, Manila, 1008 Metro Manila </p><hr>
			            </div>
			         </div>


			         <!-- Form Box -->
			         <div class="col-sm-6 form">
			            <!-- Signup Form -->
			            <div class="signup form-peice">
			            	<div class="" style="margin-top: -10px; margin-left: 350px;">
			                  	<strong> Transaction No. 
			                  	<?php 
			                     	$temp_customer_no = $last = 0;
			                     	$get_num = 'SELECT id FROM customer';
			                     	$query_getnum = mysqli_query($conn, $get_num);
			                     	$count_getnum = mysqli_num_rows($query_getnum);
			                     	if ($count_getnum > 0) {
			                     		$get_num2 = 'SELECT * FROM customer';
								    	$query_getnum2 = mysqli_query($conn, $get_num2);
								    	while ($rsz = mysqli_fetch_assoc($query_getnum2)) {
								    		$last = $rsz['customer_tr_no'];
								    	}
								    	$temp_customer_no = $last + 1;
			                     	}
			                     	else {
			                     		$temp_customer_no = 190000;
			                     	}
			                     	echo $temp_customer_no;
			                    ?>
			                	</strong>
			                  </div>
			               <form class="signup-form" method="post">
			                  <span class="error"><?php echo $error; ?></span>

			                  <div class="form-group">
			                     <label for="name">Full Name</label>
			                     <input type="text" name="fullname" id="name" class="name" required>
			                     <span class="error"></span>
			                  </div>

			                  <div class="form-group">
			                     <label for="email">Email Address</label>
			                     <input type="email" name="emailAdress" id="email" class="email" required>
			                     <span class="error"></span>
			                  </div>

			                  <div class="form-group">
			                     <label for="address">Address</label>
			                     <input type="text" name="address" id="address" class="addr" required>
			                     <span class="error"></span>
			                  </div>

			                  <div class="form-group">
			                     <label for="phone">Phone Number - <small>Optional</small></label>
			                     <input type="number" name="phone" id="phone" class='phone' maxlength='11'>
			                     <span class="error"></span>
			                  </div>

			                  <div class="form-group">
			                     Mode of Payment: 
			                     <select name='modee'>
			                     	<option value="deliver" default> Deliver </option>
			                     	<option value="walk-in"> Walk-in </option>
			                     </select>
			                     <span class="error"></span>
			                  </div>

			                  <div class="form-group" style="margin-bottom: 10px;">
			                     <input type="submit" value="Submit" name="submit" id="submit" class='btn btn-info btn-md btn-round'>
			                     <a href="checkout2.php" style="margin-left: 20px">Already have an account?</a>
			                  </div>
			               </form>
			            </div><!-- End Signup Form -->
			         </div>
			    </div>
			   </section>
	    </div>

	    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
  		<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js'></script>
  		<script src="index.js"></script>
	</body>
</html>