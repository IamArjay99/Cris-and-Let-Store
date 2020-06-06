<?php
	//session_start();
	$conn = mysqli_connect('localhost', 'root', '', 'inventory_system');

	function getIpAdd() {
	    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	    {
	      $ip=$_SERVER['HTTP_CLIENT_IP'];
	    }
	    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	    {
	      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];

	    }
	    else
	    {
	      $ip=$_SERVER['REMOTE_ADDR'];
	    }
	    return $ip;
	}

	function cart() {
		global $conn;

		//$ip = getIpAdd();
		if (isset($_GET['add_cart'])) {
			$product_id = $_GET['add_cart'];
			$defaultQty = 1;
			$check_product = "SELECT * FROM cart WHERE product_id='$product_id'";
			$run_check = mysqli_query($conn, $check_product);
		
			if (mysqli_num_rows($run_check) > 0) {
				//$insert_cart = "INSERT INTO cart (bookid, ip_add, quantity) VALUES ('$book_id', '$ip', '$quantity')";
				//$run_cart = mysqli_query($conn, $insert_cart);
				//echo "Already added";
				//echo "<script>window.open('index.php','_self')</script>";
				//echo "<script>window.alert('Already Added');</script>";
				echo "<script>window.open('cart.php?add_cart=$product_id','_self')</script>";
				//newAdded();
			}
			else {
				$insert_cart = "INSERT INTO cart (product_id, quantity) VALUES ('$product_id', '$defaultQty')";
				$run_cart = mysqli_query($conn, $insert_cart);
				//echo "Added
				if ($run_cart) {
					echo "<script>window.open('cart.php?add_cart=$product_id','_self')</script>";
				}
			}
		}	
	}

	function total_items() {
		global $conn;

		//$ip = getIpAdd();
		if (isset($_GET['add_cart'])) {
			$get_items = "SELECT * FROM cart";
			$run = mysqli_query($conn, $get_items);
			$count = mysqli_num_rows($run);
		}
		else {
			$get_items = "SELECT * FROM cart";
			$run = mysqli_query($conn, $get_items);
			$count = mysqli_num_rows($run);	
		}
		echo $count;
	}

	function newAdded() {
		global $conn;
		//$ip = getIpAdd();

		if (isset($_GET['add_cart'])) {
			$product_id = $_GET['add_cart'];
			$getcart = "SELECT * FROM products WHERE id = $product_id";
			$cart_items = mysqli_query($conn, $getcart);
			$total_price = 0;
			$count = 1;

			if ($row = mysqli_fetch_array($cart_items)) {
				$price_arr = array($row['product_price']);
				$single_price = $row['product_price'];
				//$quantity = $book['quantity'];
				//$single_price = $quantity * $single_price;
				//$total_price += $single_price;
				$product_name = $row['product_name'];
				$product_id = $row['id'];
				$product_stocks = $row['product_stocks'];

				echo "<tr>
					<td scope='row'><h3>". $count++ ."</h3></td>
					<td scope='row' class='td-actions'>
						<h3><div class='checkbox'>
							<label><input type='checkbox'  name='remove[]' value='" . $row['id'] . "' checked></label>
						</div></h3>
					</td>
					<td><img src='../../images/". $row['product_cover'] ."' width='50px' height='80px'></td>
					<td><h3>". $product_name ."</h3></td>
					<td><h3><input type='number' name='update_quantity' min='0' max='$product_stocks' class='text-right' value='";

				$sql = "SELECT * FROM cart WHERE product_id IN (SELECT id FROM products WHERE id='$product_id')";
				$result = mysqli_query($conn, $sql);

				if ($row = mysqli_fetch_array($result)) {
					$quantity = $row['quantity'];
					echo $quantity;
				}
				$total_qty = $quantity * $single_price;
				$newQuantity = $quantity;
				$newTotal_qty = $total_qty;
				$total_price += $newTotal_qty;

				echo "'></h3></td>
					<td><h3> ₱". $single_price ."</h3></td>
				</tr>";
			}
			echo "<tr><td colspan='6' align='right'><h3>TOTAL: ₱". $total_price ."</h3></td></tr>";
		}
	}

	function mycart() {
		global $conn;

		//$ip = getIpAdd();
		$getcart = "SELECT * FROM products WHERE id IN (SELECT product_id FROM cart)";
		//$qty = "SELECT * FROM cart";
		$cart_items = mysqli_query($conn, $getcart);
		$total_price = 0;
		$count = 1;

		while ($row = mysqli_fetch_array($cart_items)) {
			$price_arr = array($row['product_price']);
			$single_price = $row['product_price'];
			//$quantity = $book['quantity'];
			//$single_price = $quantity * $single_price;
			//$total_price += $single_price;
			$product_name = $row['product_name'];
			$product_id = $row['id'];

			echo "<tr>
				<td scope='row'><h3>". $count++ ."</h3></td>
				<td scope='row' class='td-actions'>
					<h3><div class='checkbox'>
						<label><input type='checkbox'  name='remove[]' value='" . $row['id'] . "'></label>
					</div></h3>
				</td>
				<td><img src='../../images/". $row['product_cover'] ."' width='50px' height='80px'></td>
				<td><h3>". $product_name ."</h3></td>
				<td><h3>";

			$sql = "SELECT * FROM cart WHERE product_id IN (SELECT id FROM products WHERE id='$product_id')";
			$result = mysqli_query($conn, $sql);

			while ($row = mysqli_fetch_array($result)) {
				$quantity = $row['quantity'];
				echo $row['quantity'];
			}
			$total_qty = $quantity * $single_price;
			$newQuantity = $quantity;
			$newTotal_qty = $total_qty;
			$total_price += $newTotal_qty;

			echo "</h3></td>
				<td><h3> ₱". $single_price ."</h3></td>
			</tr>";
		}
		echo "<tr><td colspan='6' align='right'><h3>TOTAL: ₱". $total_price ."</h3></td></tr>";
	}

	function getcats() {
		global $conn;

		$query = "SELECT * FROM types";
		$result = mysqli_query($conn, $query);
		$fetch = mysqli_num_rows($result);
		if ($fetch > 0) {
			while ($row = mysqli_fetch_array($result)) {
				echo "<li role='presentation'><a href='index.php?product_type=". $row['name'] ."'>". $row['name'] ."</a></li>";
			}
			
		}

	}

	function getItems() {
		global $conn;

		if (!isset($_GET['product_type'])) {
			$query = "SELECT * FROM products ORDER BY product_name ASC";
			$result = mysqli_query($conn, $query);

			while ($row = mysqli_fetch_array($result)) {
				echo "<div class='col-lg-4 col-md-6'>
					<div class='card'>
						<img class='card-img' height='200px' width='100px' src='../../images/". $row['product_cover'] ."'>
						<span class='content-card'>
							<h6>". $row['product_name'] ."</h6>
							<h7>". $row['product_size_number'] ."". $row['product_size'] ."</h7>
						</span>
						<a href='index.php?add_cart=". $row['id'] ."'><button class='buybtn btn btn-warning btn-round btn-sm'> Add <i class='material-icons'></i></button></a>
						<button class='knowbtn btn btn-warning btn-round btn-sm' data-toggle='modal' data-target='#".$row['id']."'>Know more</button>";

				echo "<div class='modal fade' id='".$row['id']."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
		                <div class='modal-dialog'>
		                	<div class='modal-content'>
		                		<div class='modal-header'>
		                			<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
		                			<h4 class='modal-title' id='myModalLabel'>".$row['product_name']."<br><small>". $row['product_size_number'] ."". $row['product_size'] ."</small></h4>
		                		</div>
		                		<div class='modal-body'>
		                			".$row['product_description']."<br>". $row['product_type'] ."<h3 align='right'>₱". $row['product_price'] ."</h3>
		                		</div>
		                	</div>
		                </div>
                    </div>
                    	</div>
                    </div>";    
			}
		}
	}

	function get_bycat() {
		global $conn;

		if (isset($_GET['product_type'])) {
			$product_type = $_GET['product_type'];
			$query = "SELECT * FROM products WHERE product_type = '$product_type'";
			$result = mysqli_query($conn, $query);
			$count_subject = mysqli_num_rows($result);

			if ($count_subject == 0) {
				echo "<h2> No ".$product_type." found </h2>";
			}
			while ($row = mysqli_fetch_array($result)) {
				echo "<div class='col-lg-4 col-md-6'>
					<div class='card'>
						<img class='card-img' height='200px' width='100px' src='../../images/". $row['product_cover'] ."'>
						<span class='content-card'>
							<h6>". $row['product_name'] ."</h6>
							<h7>". $row['product_size_number'] ."". $row['product_size'] ."</h7>
						</span>
						<a href='index.php?add_cart=". $row['id'] ."'><button class='buybtn btn btn-warning btn-round btn-sm'> Add <i class='material-icons'></i></button></a>
						<button class='knowbtn btn btn-warning btn-round btn-sm' data-toggle='modal' data-target='#".$row['id']."'>Know more</button>";

				echo "<div class='modal fade' id='".$row['id']."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
		                <div class='modal-dialog'>
		                	<div class='modal-content'>
		                		<div class='modal-header'>
		                			<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
		                			<h4 class='modal-title' id='myModalLabel'>".$row['product_name']."<br><small>". $row['product_size_number'] ."". $row['product_size'] ."</small></h4>
		                		</div>
		                		<div class='modal-body'>
		                			".$row['product_description']."<br>". $row['product_type'] ."<h3 align='right'>₱". $row['product_price'] ."</h3>
		                		</div>
		                	</div>
		                </div>
                    </div>
                    	</div>
                    </div>";    
			}
		}
	}
?>


