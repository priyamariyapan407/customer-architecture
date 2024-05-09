<?php

        $pdf = new FPDF();
        if(isset($serialnumbers) && is_array($serialnumbers)) {
        foreach ($serialnumbers as $serial_number) {
        $pdf->AddPage();
        $pdf->SetTitle('Monthly Consolidated Report');
        $pdf->SetY(0);
        $pdf->SetFont("Arial", "B", "13");
        $pdf->SetXY(5, $pdf->GetY() + 15);
        $x          = 15;
        $y          = 10;
        $CI         =& get_instance();
        $image_name = $CI->config->base_url() . 'assets/dist/img/smoad_rect_logo_5g.png';
        $pdf->Cell($x, $y, $pdf->Image($image_name, 10, 7, 33.78), 0, 0, 'L', false);
 
        $pageWidth  = 210;
        $pageHeight = 297;
        $pdf->SetFont("Arial", "B", "11");
        $pdf->SetXY(160, $pdf->GetY());
        $pdf->Cell(10, 10, "Date: " . date("F j, Y"));
 
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(10, $pdf->GetY() + 7);
        $pdf->Cell($x, $y, "Serial Number: " );
 
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(10, $pdf->GetY() + 7);
        $pdf->Cell($x, $y, "Details: " );
 
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(10, $pdf->GetY() + 7);
        $pdf->Cell($x, $y, "Model: ");
 
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(10, $pdf->GetY() + 7);
        $pdf->Cell($x, $y, "Model Variant: ");
 
        $pdf->SetFont("Arial", "B", "13");
        $pdf->SetXY(10, $pdf->GetY() + 18);

        $pdf->Cell($x + 100, $y, "Consolidated Report");
 
        $pdf->SetFont("Arial", "B", "12");
        $pdf->SetXY(10, $pdf->GetY() + 10);
        $pdf->Cell($x, $y + 2, "Total Data Transferred:");
        $border = 0;
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(12, $pdf->GetY() + 12);
        $pdf->SetFillColor(68, 68, 68);
        $pdf->SetTextColor(255, 255, 255);

        $pdf->Cell(30, 10, 'Port', $border, 0, 'C', true);
        $pdf->Cell(30, 10, 'RX', $border, 0, 'C', true);
        $pdf->Cell(30, 10, 'TX', $border, 0, 'C', true);
        $pdf->Cell(30, 10, 'Down', $border, 0, 'C', true);
        $pdf->Cell(30, 10, 'Latency', $border, 0, 'C', true);
        $pdf->Cell(30, 10, 'Jitter', $border, 1, 'C', true); /*end of line*/
        /*Heading Of the table end*/
        $pdf->SetFont('Arial', '', '10');
    }
}

$pdf->Output();