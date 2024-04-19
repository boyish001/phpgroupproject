<?php
    ob_end_clean();
    require('fpdf186/fpdf.php');
    require('Database/order.php');

    $order = new order();
    $database = $order->getDatabase();

    class InvoicePDF extends FPDF {
        function Header() {
            $logoWidth = 80;
            $logoHeight = 0;
            $this->SetFillColor(255, 255, 255);
            $this->Rect(0, 0, $this->GetPageWidth(), $this->GetPageHeight(), 'F');

            $this->SetX((210 - $logoWidth) / 2);

            $this->Image('Images/logo.png', null, 6, $logoWidth, $logoHeight);
            $this->SetFont('Arial','B',14);

            $this->Ln(28);

            $this->SetFont('Arial','',12);
            $this->Cell(0,9,'',0,1,'C');
            $this->Cell(0,1,'23, Brave street,',0,1,'C');
            $this->Cell(0,10,'Kitchener,ON, N5N 7E6',0,1,'C');

            $this->SetFont('Arial','',12);
            $this->Cell(0,10,'Contact Number: +1 (123)-456-7890, +1 (987)-654-3210',0,1,'C');
            $this->SetDrawColor(0, 0, 0);
            $this->SetLineWidth(0.2); 
            $this->Line(30, $this->GetY(), 180, $this->GetY()); 

            $this->Ln(5);
        }

        function Footer() {
            $this->SetY(-25);
            $this->SetFont('Arial','I',16);
            $this->Cell(0,10,'Payment Completed',0,0,'C');
            $this->Ln(10); 
            $this->SetTextColor(0, 0, 0);
            $this->SetFont('Arial','I',12);
            $this->Cell(0,10,"Ready for another round of delight? Place your order now and let the magic continue!",0,1,'C');

        }
    }

    $orderId = isset($_POST['order_id']) ? $_POST['order_id'] : null;
    
    if ($orderId)
    {
        
        $querydata = $order->getOrderByID($orderId);

        if($querydata){
            $data = mysqli_fetch_assoc($querydata);

            $pdf = new InvoicePDF();
            $pdf->AddPage();
            

            $pdf->SetRightMargin(30);
            $pdf->SetLeftMargin(30);

            date_default_timezone_set('America/New_York');

            $invoiceDate = date('Y-m-d');

            $pdf->SetFont('Arial', '', 12);

            $pdf->Cell(0, 10, 'Invoice Date: ' . $invoiceDate, 0, 1, 'R');
            $pdf->Ln(10); 


            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(0, 10, 'Order ID: '. $data['id'], 0, 1, 'C');

            $pdf->SetFont('Arial', '', 12);
            $pdf->SetY($pdf->GetY() + 10);


            $pdf->Cell(40, 10, 'Name', 1);
            $pdf->Cell(0, 10, $data['name'], 1, 1);

            $pdf->Cell(40, 10, 'Contact Email', 1);
            $pdf->Cell(0, 10, $data['email'], 1, 1);

            $pdf->Cell(40, 10, 'Phone', 1);
            $pdf->Cell(0, 10, $data['phone'], 1, 1);

            $pdf->Cell(40, 30, 'Delivery Address', 1);
            $pdf->MultiCell(0, 10, $data['street']."\n".$data['city'].",".$data['province']."\n".$data['postalCode'], 1, 'L');


            $lastfour = substr($data['cardNumber'], -4);

            $pdf->Cell(40, 10, 'Payment Card', 1);
            $pdf->Cell(0, 10, "************".$lastfour, 1, 1);

            $pdf->Cell(40, 10, 'Payment Date', 1);
            $pdf->Cell(0, 10, $data['date'], 1, 1);

            $pdf->Ln(10); 

            $pdf->SetFont('Arial', 'B', 14);
            $pdf->SetTextColor(25, 82, 31);
            $pdf->Cell(0, 10, 'Amount Paid: $'. $data['total'], 0, 1, 'C');


            $pdf->Output('I', $data['id'].".pdf");

        }
        else {
            echo "Error fetching order details";
        }
        
    }
    else {
        echo "Order ID not provided";
    }


?>