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
			$this->SetX(15);
			$this->SetFont('Arial', 'B', 15);
			$this->Cell(0, 30, "CUSTOMERS ");
		}
		function headerTable() {
			$this->SetY(57);
			$this->SetX(15);
			$this->SetFont('Times', 'B', 11);
			$this->Cell(10,10,'#',1,0,'C');
			$this->Cell(30,10,'Transaction No.',1,0,'C');
			$this->Cell(35,10,'Customer Name',1,0,'C');
			$this->Cell(35,10,'Customer Email',1,0,'C');
			$this->Cell(35,10,'Customer Address',1,0,'C');
			$this->Cell(35,10,'Customer Number',1,0,'C');
		}
		function viewTable() {
			global $conn;
			global $session_user;
			$this->SetFont('Times', '', 15);
			$this->SetTextColor(50);
			$count = 0;
			$total_cost = 0;
			$db = "SELECT * FROM customer";
			$stmt = mysqli_query($conn, $db);
			$this->SetY(67);
			$this->SetX(15);
			while ($row = mysqli_fetch_array($stmt)) {
				$this->SetX(15);
				$customer_tr_no = $row['customer_tr_no'];
				$customer_name = $row['customer_name'];
				$customer_email = $row['customer_email'];
				$customer_address = $row['customer_address'];
				$customer_number = $row['customer_number'];
				$this->Cell(10,10,$count+=1,1,0,'C');
				$fontSize = 15;
				$decrement_step = 0.1;
				$lineWidth = 30;
				while ($this->GetStringWidth($customer_tr_no) > $lineWidth) {
					$this->SetFontSize($fontSize -= $decrement_step);
				}
				$this->Cell(30,10,$customer_tr_no,1,0,'C');
				$this->SetFont('Times', '', 15);
				$lineWidth = 35;
				while ($this->GetStringWidth($customer_name) > $lineWidth) {
					$this->SetFontSize($fontSize -= $decrement_step);
				}
				$this->Cell(35,10,$customer_name,1,0,'C');
				$this->SetFont('Times', '', 15);
				$lineWidth = 33;
				while ($this->GetStringWidth($customer_email) > $lineWidth) {
					$this->SetFontSize($fontSize -= $decrement_step);
				}
				$this->Cell(35,10,$customer_email,1,0,'C');
				$this->SetFont('Times', '', 15);
				$lineWidth = 35;
				while ($this->GetStringWidth($customer_address) > $lineWidth) {
					$this->SetFontSize($fontSize -= $decrement_step);
				}
				$this->Cell(35,10,$customer_address,1,0,'C');
				$this->SetFont('Times', '', 15);
				while ($this->GetStringWidth($customer_number) > $lineWidth) {
					$this->SetFontSize($fontSize -= $decrement_step);
				}
				$this->Cell(35,10,$customer_number,1,0,'C');
				$this->Ln();
			}
		}
	}

	$pdf = new myPDF();
	$pdf->AddPage();
	$pdf->tr();
	$pdf->headerTable();
	$pdf->viewTable();
	$pdf->Output('customer.pdf', 'F');
	header("Location: customer.pdf");
?>