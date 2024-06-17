<?php
ob_start();
include('command/conn.php');
require('fpdf/fpdf.php');
session_start();
if (!isset($_COOKIE['email']) && !isset($_COOKIE['pass'])) {
    header("Location: http://localhost/newproject/login/index.php");
    exit;
}

$userid = $_COOKIE['email'];

if (isset($_GET['b_no'])) {
    $bno = $_GET['b_no'];
}
if (isset($bno)) {
    $query_cname = "select customer_name,date from billing_header where bill_no='$bno'";
    $result_cname = mysqli_query($con, $query_cname);
    while ($row = mysqli_fetch_row($result_cname)) {
        $customerName = $row[0];
        // $date = $row[1];
        $dt = $row[1];
        $date = strstr($dt, ' ', true);
    }

    $query_cdetails = "select c_add,c_phone from customer where c_name='$customerName'";
    $result_cdetails = mysqli_query($con, $query_cdetails);
    while ($row = mysqli_fetch_row($result_cdetails)) {
        $customer_add = $row[0];
        $customer_phone = $row[1];
    }

    $pdf = new FPDF();
    $pdf->AddPage();

    // Add Logo
    $pdf->Image('assets\images\favicon-32x32.png', 10, 6, 30);

    // Company Details
    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(80);
    $pdf->Cell(30, 10, 'MARUTI FABRICS', 0, 1, 'C');

    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(0, 10, 'Plot No. 20-21/A, Sahaj Ind. Society, Bamroli, Surat.', 0, 1, 'C');
    $pdf->Cell(0, 2, 'Mobile: 9328210985   GSTIN: 24BCOPP6008E1ZN', 0, 1, 'C');
    $pdf->Ln(18);

    $billNo = $_SESSION['bill_no'];
    // Invoice Details
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(95, 10, 'Invoice No.: ' . $bno, 1);
    $pdf->Cell(95, 10, 'Invoice Date: ' . $date, 1, 1);
    $pdf->Cell(95, 10, 'Bill To :', 1);
    $pdf->Cell(95, 10, 'Ship To :', 1, 1);

    // Customer Information
    $pdf->SetFont('Arial', '', 10);
    $customerInfo = "Customer Name : " . $customerName . "\n";
    $customerInfo .= "Address : " . $customer_add . "\n";

    $extraInfo = "Mobile: " . $customer_phone . "\n";

    $pdf->MultiCell(95, 5, $customerInfo, 1);
    $pdf->SetXY(105, 70); // Adjust position to match the "Ship To" section
    $pdf->MultiCell(95, 5, $customerInfo, 1);
    $pdf->Ln(5);
    $pdf->MultiCell(95, 5, $extraInfo, 0);
    $pdf->Ln(10);

    // Items Table Header
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(10, 10, 'Sr.', 1);
    $pdf->Cell(60, 10, 'Product Name', 1);
    $pdf->Cell(20, 10, 'Qty', 1);
    $pdf->Cell(30, 10, 'Rate', 1);
    $pdf->Cell(30, 10, 'Tax', 1);
    $pdf->Cell(30, 10, 'Amount', 1, 1);

    // Items Data
    $i = 1;
    $total = 0;
    $rs = "RS. ";
    $query_bill_detail = "select product_name,product_qty,product_price,total,gst_amount from billing_details where bill_no='$bno'";
    $result_bill_detail = mysqli_query($con, $query_bill_detail);
    while ($val = mysqli_fetch_row($result_bill_detail)) {
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 10, $i, 1);
        $pdf->Cell(60, 10, $val[0], 1);
        $pdf->Cell(20, 10, $val[1], 1);
        $pdf->Cell(30, 10, number_format($val[2]), 1);
        $pdf->Cell(30, 10, number_format($val[4]), 1);
        $pdf->Cell(30, 10, number_format($val[3]), 1, 1);
        $total = $total + $val[3];
        $i++;
    }

    // Summary
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(150, 10, 'TOTAL', 1);
    $pdf->Cell(30, 10, $rs . number_format($total), 1, 1);
    $pdf->Ln(5);

    // Terms and Conditions
    $pdf->Cell(190, 10, 'TERMS AND CONDITIONS', 0, 1);
    $pdf->SetFont('Arial', '', 8);
    $pdf->MultiCell(190, 5, "1. Goods once sold will not be taken back or exchanged\n2. All disputes are subject to [ENTER_YOUR_CITY_NAME] jurisdiction only", 0, 1);
    $pdf->Ln(5);

    $pdf->Output("I", $bno . ".pdf");
}

if (isset($_GET['d_bno'])) {
    $download = $_GET['d_bno'];
}
if (isset($download)) {
    $query_cname = "select customer_name,date from billing_header where bill_no='$download'";
    $result_cname = mysqli_query($con, $query_cname);
    while ($row = mysqli_fetch_row($result_cname)) {
        $customerName = $row[0];
        // $date = $row[1];
        $dt = $row[1];
        $date = strstr($dt, ' ', true);
    }

    $query_cdetails = "select c_add,c_phone from customer where c_name='$customerName'";
    $result_cdetails = mysqli_query($con, $query_cdetails);
    while ($row = mysqli_fetch_row($result_cdetails)) {
        $customer_add = $row[0];
        $customer_phone = $row[1];
    }

    $pdf = new FPDF();
    $pdf->AddPage();

    // Add Logo
    $pdf->Image('assets\images\favicon-32x32.png', 10, 6, 30);

    // Company Details
    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(80);
    $pdf->Cell(30, 10, 'MARUTI FABRICS', 0, 1, 'C');

    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(0, 10, 'Plot No. 20-21/A, Sahaj Ind. Society, Bamroli, Surat.', 0, 1, 'C');
    $pdf->Cell(0, 2, 'Mobile: 9328210985   GSTIN: 24BCOPP6008E1ZN', 0, 1, 'C');
    $pdf->Ln(18);

    $billNo = $_SESSION['bill_no'];
    // Invoice Details
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(95, 10, 'Invoice No.: ' . $download, 1);
    $pdf->Cell(95, 10, 'Invoice Date: ' . $date, 1, 1);
    $pdf->Cell(95, 10, 'Bill To :', 1);
    $pdf->Cell(95, 10, 'Ship To :', 1, 1);

    // Customer Information
    $pdf->SetFont('Arial', '', 10);
    $customerInfo = "Customer Name : " . $customerName . "\n";
    $customerInfo .= "Address : " . $customer_add . "\n";

    $extraInfo = "Mobile: " . $customer_phone . "\n";

    $pdf->MultiCell(95, 5, $customerInfo, 1);
    $pdf->SetXY(105, 70); // Adjust position to match the "Ship To" section
    $pdf->MultiCell(95, 5, $customerInfo, 1);
    $pdf->Ln(5);
    $pdf->MultiCell(95, 5, $extraInfo, 0);
    $pdf->Ln(10);

    // Items Table Header
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(10, 10, 'Sr.', 1);
    $pdf->Cell(60, 10, 'Product Name', 1);
    $pdf->Cell(20, 10, 'Qty', 1);
    $pdf->Cell(30, 10, 'Rate', 1);
    $pdf->Cell(30, 10, 'Tax', 1);
    $pdf->Cell(30, 10, 'Amount', 1, 1);

    // Items Data
    $i = 1;
    $total = 0;
    $rs = "RS. ";
    $query_bill_detail = "select product_name,product_qty,product_price,total,gst_amount from billing_details where bill_no='$download'";
    $result_bill_detail = mysqli_query($con, $query_bill_detail);
    while ($val = mysqli_fetch_row($result_bill_detail)) {
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 10, $i, 1);
        $pdf->Cell(60, 10, $val[0], 1);
        $pdf->Cell(20, 10, $val[1], 1);
        $pdf->Cell(30, 10, number_format($val[2]), 1);
        $pdf->Cell(30, 10, number_format($val[4]), 1);
        $pdf->Cell(30, 10, number_format($val[3]), 1, 1);
        $total = $total + $val[3];
        $i++;
    }

    // Summary
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(150, 10, 'TOTAL', 1);
    $pdf->Cell(30, 10, $rs . number_format($total), 1, 1);
    $pdf->Ln(5);

    // Terms and Conditions
    $pdf->Cell(190, 10, 'TERMS AND CONDITIONS', 0, 1);
    $pdf->SetFont('Arial', '', 8);
    $pdf->MultiCell(190, 5, "1. Goods once sold will not be taken back or exchanged\n2. All disputes are subject to [ENTER_YOUR_CITY_NAME] jurisdiction only", 0, 1);
    $pdf->Ln(5);

    $pdf->Output("D", $download . ".pdf");
}
