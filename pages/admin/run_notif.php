<?php
    include '../../include/db.php';
    session_start();

    if (isset($_SESSION['admin_fname'])) {
        $session_user = $_SESSION['admin_fname'];
    }
    else {
        header("Location: index.php");
    }

    if (isset($_GET['customer_tr_no'])) {
        $customer_tr_no = $_GET['customer_tr_no'];
        if (isset($_GET['status'])) {
            $delete = "DELETE FROM temp_cart WHERE customer_tr_no = '$customer_tr_no'";
            $delete2 = "DELETE FROM customer WHERE customer_tr_no = '$customer_tr_no'";;
            if ($run_delete = mysqli_query($conn, $delete)) {
                if ($run_delete2 = mysqli_query($conn, $delete2)) {
                    header("Location: order.php");
                }
            }
            else {
                header("Location: order.php?customer_tr_no=$customer_tr_no");
            }
        }
    }
?>