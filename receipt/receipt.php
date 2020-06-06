<?php
	
	$conn = mysqli_connect("localhost", "root", "", "inventory_system");

	if (!$conn) {
		die("Connection failed... " . mysqli_connect_error());
	}
	else {
		// echo "Connected successfully";
	}

	session_start();
	if (isset($_SESSION['customer_tr_no'])) {
        $session_user = $_SESSION['customer_tr_no'];
    }
    else {
        header("Location: checkout.php");
    }

	require 'fpdf.php';

	$db_ = "SELECT * FROM customer WHERE customer_tr_no = '$session_user'";
	$stmt_ = mysqli_query($conn, $db_);
	while ($row_ = mysqli_fetch_array($stmt_)) {
		$customer_tr_no = $row_['customer_tr_no'];
		$fullname = $row_['customer_name'];
		$email = $row_['customer_email'];
		$phone = $row_['customer_number'];
		$address = $row_['customer_address'];
	}
	


	class myPDF extends FPDF {
		function _construct ($orientation = 'P', $unit = 'pt', $format = 'Letter', $margin = 40) {
	        $this->FPDF($orientation, $unit, $format);
	        $this->SetTopMargin($margin);
	        $this->SetLeftMargin($margin);
	        $this->SetRightMargin($margin);
	        $this->SetAutoPageBreak(true, $margin);
	    }
		function header() {
			$this->SetFont('Arial', 'B', 20);
			$this->SetTextColor(0);
			$this->Cell(190,30,"Cris & Let Store",0,0,'C');
			$this->Ln();
			$this->SetFont('Arial', '', 12);
			$this->SetTextColor(50);
			$this->Cell(0,-15,"1891 Recto Ave, Sampaloc, Manila, 1008 Metro Manila",0,0,'C');
		}
		function footer() {
			$this->SetY(-25);
			$this->SetFont('Arial', 'B', 10);
			$this->Cell(0,10,"Thank you for trusting Cris & Let Store",0,0,'C');
		}
		function tr() {
			global $customer_tr_no;
			$this->SetX(131);
			$this->SetFont('Arial', 'B', 12);
			$this->Cell(0, 30, "Transaction No. " .$customer_tr_no);
			$this->SetX(146);
			$this->SetFont('Arial', 'I', 12);
			$this->Cell(0, 42, date('F j, Y'), 0, 1);
		}
		function customerInfo() {
			global $fullname, $email, $phone, $address;
			$this->SetX(18);
			$this->SetFont('Arial', 'B', 12);
			$this->Cell(0, -10, "Customer Information:");
			$this->SetFont('Arial', '', 12);
			$this->SetX(25);
			$this->Cell(0, 2, "Fullname: ".$fullname);
			$this->SetX(25);
			$this->Cell(0, 14, "Email: ".$email);
			$this->SetX(25);
			$this->Cell(0, 26, "Phone: ".$phone);
			$this->SetX(25);
			$this->Cell(0, 38, "Address: ".$address, 'I');
		}
		function headerTable() {
			$this->SetY(120);
			$this->SetX(22);
			$this->SetFont('Times', 'B', 15);
			$this->Cell(10,10,'#',1,0,'C');
			$this->Cell(75,10,'Product',1,0,'C');
			$this->Cell(20,10,'Qty',1,0,'C');
			$this->Cell(30,10,'Price',1,0,'C');
			$this->Cell(30,10,'Total',1,0,'C');
		}
		function viewTable() {
			global $conn;
			global $session_user;
			$this->SetFont('Times', '', 15);
			$this->SetTextColor(50);
			$count = 0;
			$total_cost = 0;
			$db = "SELECT * FROM temp_cart WHERE customer_tr_no = '$session_user'";
			$stmt = mysqli_query($conn, $db);
			$this->SetY(130);
			$this->SetX(22);
			while ($row = mysqli_fetch_array($stmt)) {
				$this->SetX(22);
				$product_id = $row['product_id'];
				$quantity = $row['quantity'];
				$price = $row['price'];
				$total = $row['cost'];
				$total_cost += $total;
				$this->Cell(10,10,$count+=1,1,0,'C');
				$db2 = "SELECT * FROM products WHERE id = '$product_id'";
				$query2 = mysqli_query($conn, $db2);
				while ($row2 = mysqli_fetch_array($query2)) {
					$item = $row2['product_name'];
					$fontSize = 15;
					$decrement_step = 0.1;
					$lineWidth = 68;
					while ($this->GetStringWidth($item) > $lineWidth) {
						$this->SetFontSize($fontSize -= $decrement_step);
					}
					$this->Cell(75,10,$item,1,0,'L');
				}
				$this->SetFont('Times', '', 15);
				$this->Cell(20,10,$quantity,1,0,'C');
				$this->Cell(30,10,$price,1,0,'C');
				$this->Cell(30,10,$total,1,0,'C');	
				$this->Ln();
			}
			$this->SetFont('Times', 'B', 18);
			$this->SetX(22);
			$this->Cell(165,10,"TOTAL: ".$total_cost." ",1,0,'R');
		}
	}

	$pdf = new myPDF();
	$pdf->AddPage();

	$pdf->tr();
	$pdf->customerInfo();
	$pdf->headerTable();
	$pdf->viewTable();
	$pdf->Output('receipt.pdf', 'F');
	header("Location: receipt.pdf");
?>