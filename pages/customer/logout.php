<?php
	include '../../include/db.php';

	session_start();

	$remove = "TRUNCATE TABLE cart";
	$result = mysqli_query($conn, $remove);

	if ($result) {
		session_unset();
		session_destroy();

		header("Location: index.php");
	}
	else {
		header("Location: payment.php");
	}

?>