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

$bno = $_GET['b_no'];
if (isset($bno)) {
    $query_cname = "select customer_name,date from billing_header where bill_no='$bno'";
    $result_cname = mysqli_query($con, $query_cname);
    while ($row = mysqli_fetch_row($result_cname)) {
        $customerName = $row[0];
        // $date = $row[1];
        $dt = $row[1];
        $date = strstr($dt, ' ', true);
    }
    $pdf = new FPDF();
    $pdf->AddPage();

    $pdf->SetFont('Arial', 'B', 20);

    $pdf->Cell(71, 10, '', 0, 0);
    $pdf->Cell(59, 5, 'Invoice', 0, 0);
    $pdf->Cell(59, 10, '', 0, 1);

    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(71, 5, 'Customer Details', 0, 0);
    $pdf->Cell(59, 5, '', 0, 0);
    $pdf->Cell(59, 5, 'Invoice Details', 0, 1);

    $pdf->SetFont('Courier', '', 12);

    $pdf->Cell(130, 9, 'Name : ' . $customerName, 0, 0);
    // $pdf->Cell(25, 5, 'Customer:', 0, 0);
    // $pdf->Cell(34, 5, 'ABC', 0, 1);

    // $pdf->Cell(130, 5, 'Delhi, 751001', 0, 0);
    $pdf->Cell(25, 9, 'Date:', 0, 0);
    $pdf->Cell(34, 9, $date, 0, 1);

    $pdf->Cell(130, 9, '', 0, 0);
    $pdf->Cell(25, 1, 'Bill No:', 0, 0);
    $pdf->Cell(34, 1, $bno, 0, 1);


    // $pdf->SetFont('Arial', 'B', 15);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(189, 10, '', 0, 1);

    $pdf->Cell(50, 10, '', 0, 1);

    $pdf->SetFont('Courier', 'B', 12);
    $pdf->Cell(10, 6, 'Sr', 0, 0, 'C');
    $pdf->Cell(80, 6, 'Product Name', 0, 0, 'C');
    $pdf->Cell(23, 6, 'Qty', 0, 0, 'C');
    $pdf->Cell(30, 6, 'Unit Price', 0, 0, 'C');
    $pdf->Cell(25, 6, 'Total', 0, 1, 'C');
    $pdf->SetFont('Courier', '', 12);
    $i = 1;
    $total = 0;

    $query_bill_detail = "select product_name,product_qty,product_price,total from billing_details where bill_no='$bno'";
    $result_bill_detail = mysqli_query($con, $query_bill_detail);
    while ($val = mysqli_fetch_row($result_bill_detail)) {
        $pdf->Cell(10, 6, $i, 0, 0, 'C');
        $pdf->Cell(80, 6, $val[0], 0, 0, 'C');
        $pdf->Cell(23, 6, $val[1], 0, 0, 'C');
        $pdf->Cell(30, 6, $val[2], 0, 0, 'C');
        $pdf->Cell(25, 6, $val[3], 0, 1, 'C');
        $total = $total + $val[3];
        $i++;
    }


    $pdf->Cell(118, 6, '', 0, 0);
    $pdf->Cell(25, 6, 'Total', 1, 0, 'C');
    $pdf->Cell(25, 6, $total, 1, 1, 'C');

    $pdf->Line(10, 61, 178, 61);

    $pdf->Output("I", $bno . ".pdf");
}
