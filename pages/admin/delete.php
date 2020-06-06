<?php
	include '../../include/db.php';
    session_start();

    if (isset($_SESSION['admin_fname'])) {
        $session_user = $_SESSION['admin_fname'];
    }
    else {
        header("Location: index.php");
    }

    // deleting product

    if (isset($_GET['id'])) {
    	$product_id = $_GET['id'];
    	$select_product = "DELETE FROM products WHERE id = '$product_id'";
    	$select_query = mysqli_query($conn, $select_product);
    	if ($select_query) {
    		header("Location: products.php");
    	}
    }
?>