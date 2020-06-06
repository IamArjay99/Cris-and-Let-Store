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
	                    <li class="active"><a href="index.php"> Home </a></li>
	                    <li><a href="../admin/index.php"> ADMINISTRATOR </a></li>
	                    <li><a> HI, GUEST </a></li>
	                    <li><a href="cart.php"> GO TO CART <span class="badge"><?php total_items(); ?></span></a></li>

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

		<div class="row">
            <div class="col-md-12">
                <div class="carousel slide multi-item-carousel" id="theCarousel">
                    <div class="carousel-inner">
                        <div class="item active">
                            <div class="col-xs-4" id="bk1">
                                <img src="../../assets/images/rc_p.jpg">
                                <div class="c-content "><b> RC Cola </b><br><br>
                                    <p> 
                                    	RC Cola. RC Cola, short for Royal Crown Cola, is a cola-flavored soft drink developed in 1905 by Claud A. Hatcher, a pharmacist in Columbus, Georgia, United States of America. 
                                    </p>
                                </div>

                            </div>
                        </div>
                        <div class="item">
                            <div class="col-xs-4" id="bk2">
                                <img src="../../assets/images/san_miguel.jpg">
                                <div class="c-content "><b> San Miguel Beer </b><br><br>
                                	<p>
                                		San Miguel Beer refers to San Miguel Pale Pilsen, a Filipino pale lager produced by San Miguel Brewery . Established in 1890 by the original San Miguel Brewery, it is the largest selling beer in the Argentina and Hong Kong.
                                	</p>
                                </div>

                            </div>
                        </div>
                        <div class="item">
                            <div class="col-xs-4" id="bk4">
                            	<img src="../../assets/images/zest-o.jpg">
                                <div class="c-content "><b> Zest-o </b><br><br>
                                	<p>
                                		Zest-O Corporation is a beverage company in the Philippines. It was founded in 1981 as SEMEXCO Marketing Corporation by businessman Alfredo M. Yao.
                                	</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-xs-4" id="bk3">
                                <img src="../../assets/images/wilkins.jpg">
                                <div class="c-content "><b> Wilkins </b><br>
                                	<p>
                                		Since the brand’s launch in the Philippines in 1997, WILKINS has always been committed to providing households with only safe drinking water. Through the years, we have provided millions of Filipinos with water products that are clean, safe and internationally certified.
                                	</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="left carousel-control" href="#theCarousel" data-slide="prev"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></a>
                    <a class="right carousel-control" href="#theCarousel" data-slide="next"></a>
                </div>
            </div>
        </div>
        <!-- carosel end -->

        <div class="container-fluid">
        	<div class="row">
	        	<div class="col-lg-2 col-md-2" id="myScrollspy">
	                <ul data-offset-top="225" data-spy="affix" class="nav nav-pills  nav-stacked">
                    	<li role="presentation"><a href="index.php">All books</a></li>
                    	<?php getcats();?>

                	</ul>
	            </div>
	            <div class="col-lg-10 col-md-10" id="mainarea">
	            	<div class="container-fluid">
	            		<?php cart(); ?>
	            		<!-- adding books -->
	            		<div class="row">
	            			<?php
	            				if (isset($_GET['search'])) {
	            					$search_query = $_GET['user_query'];
	            					$sql = "SELECT * FROM products WHERE product_name LIKE '%$search_query%' OR product_description LIKE '%$search_query%' OR product_type LIKE '%$search_query%'";
	            					$result = mysqli_query($conn, $sql);
	            					$queryResult = mysqli_num_rows($result);
	            					//echo $queryResult;
	            					if ($queryResult > 0) {
	            						while ($row = mysqli_fetch_array($result)) {					
											echo "<div class='col-lg-4 col-md-6'>
												<div class='card'>
													<img class='card-img' height='200px' width='100px' src='../../images/". $row['product_cover'] ."'>
													<span class='content-card'>
														<h6>". $row['product_name'] ."</h6>
														<h7>".$row['product_size_number']."". $row['product_size'] ."</h7>
													</span>
													<a href='index.php?add_cart=". $row['id'] ."'><button class='buybtn btn btn-warning btn-round btn-sm'> Add <i class='material-icons'></i></button></a>
													<button class='knowbtn btn btn-warning btn-round btn-sm' data-toggle='modal' data-target='#".$row['id']."'>Know more</button>";

											echo "<div class='modal fade' id='".$row['id']."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
									                <div class='modal-dialog'>
									                	<div class='modal-content'>
									                		<div class='modal-header'>
									                			<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
									                			<h4 class='modal-title' id='myModalLabel'>".$row['product_name']."<br><small>". $row['product_size'] ."</small></h4>
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
		            				else {
										echo "There are no results matching your search";
									}
								}
	            			?>
	            		</div>
	            	</div>
	            </div>
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

	    <!--<script src="../js/jquery.js"></script>
	    <script src="../js/proper.js"></script>
	    <script src="../js/javascript.js"></script>-->
	</body>
</html>