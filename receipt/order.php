<?php
	
	$conn = mysqli_connect("localhost", "root", "", "inventory_system");

	if (!$conn) {
		die("Connection failed... " . mysqli_connect_error());
	}
	else {
		// echo "Connected successfully";
	}

	session_start();
    if (isset($_SESSION['first_name'])) {
        $session_user = $_SESSION['first_name'];
    }
    else {
        header("Location: ../login.php");
    }

	require 'fpdf.php';

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
			$this->Cell(190,30," Cris & Let Store ",0,0,'C');
			$this->Ln();
			$this->SetFont('Arial', '', 12);
			$this->SetTextColor(50);
			$this->Cell(0,-15,"1891 Recto Ave, Sampaloc, Manila, 1008 Metro Manila",0,0,'C');
		}
		function footer() {
			$this->SetY(-25);
			$this->SetFont('Arial', 'B', 10);
			$this->Cell(0,10,"",0,0,'C');
		}
		function tr() {
			$this->SetY(37);
			$this->SetX(22);
			$this->SetFont('Arial', 'B', 15);
			$this->Cell(0, 30, "ORDER ");
		}
		function headerTable() {
			$this->SetY(57);
			$this->SetX(22);
			$this->SetFont('Times', 'B', 15);
			$this->Cell(10,10,'#',1,0,'C');
			$this->Cell(70,10,'Product',1,0,'C');
			$this->Cell(15,10,'Qty',1,0,'C');
			$this->Cell(20,10,'Price',1,0,'C');
			$this->Cell(25,10,'Total',1,0,'C');
			$this->Cell(25,10,'Date',1,0,'C');
		}
		function viewTable() {
			global $conn;
			global $session_user;
			$this->SetFont('Times', '', 15);
			$this->SetTextColor(50);
			$count = 0;
			$total_cost = 0;
			$db = "SELECT * FROM temp_cart";
			$stmt = mysqli_query($conn, $db);
			$this->SetY(67);
			$this->SetX(22);
			while ($row = mysqli_fetch_array($stmt)) {
				$this->SetX(22);
				$product_id = $row['product_id'];
				$quantity = $row['quantity'];
				$price = $row['price'];
				$date = $row['date_'];
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
					$this->Cell(70,10,$item,1,0,'C');
				}
				$this->SetFont('Times', '', 15);
				$this->Cell(15,10,$quantity,1,0,'C');
				$this->Cell(20,10,'P'.$price,1,0,'C');
				$this->Cell(25,10,'P'.$total,1,0,'C');
				$this->Cell(25,10,date('m/j/y',strtotime($date)),1,0,'C');	
				$this->Ln();
			}
			$this->SetFont('Times', 'B', 18);
			$this->SetX(22);
			$this->Cell(165,10,"TOTAL: P".$total_cost." ",1,0,'R');
		}
	}

	$pdf = new myPDF();
	$pdf->AddPage();
	$pdf->tr();
	$pdf->headerTable();
	$pdf->viewTable();
	$pdf->Output('order.pdf', 'F');
	header("Location: order.pdf");
?>