<?php
include('conn.php');
require('../fpdf/fpdf.php');
session_start();
if (!isset($_COOKIE['email']) && !isset($_COOKIE['pass'])) {
    header("Location: http://localhost/newproject/login/index.php");
    exit;
}

$u_email = $_COOKIE['email'];

$query_uid = "select id from user where email='$u_email'";
$result = mysqli_query($con, $query_uid);
$row = mysqli_fetch_row($result);
$user_ID = $row[0];
?>


<?php
if (isset($_POST['purchase_btn_pdf'])) {
    $sdate = $_POST['start_date'];
    $edate = $_POST['end_date'];
    $user_ID = $_POST['userID'];
    $pdf = new FPDF();
    $pdf->AddPage();

    // Add Logo
    $pdf->Image('..\assets\images\favicon-32x32.png', 10, 6, 30);

    // Company Details
    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(80);
    $pdf->Cell(30, 10, 'MARUTI FABRICS', 0, 1, 'C');

    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(0, 10, 'Plot No. 20-21/A, Sahaj Ind. Society, Bamroli, Surat.', 0, 1, 'C');
    $pdf->Cell(0, 2, 'Mobile: 9328210985   GSTIN: 24BCOPP6008E1ZN', 0, 1, 'C');
    $pdf->Ln(5);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Purchase Report', 0, 1, 'C');
    $pdf->Ln(5);

    $billNo = $_SESSION['bill_no'];
    // Invoice Details
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(95, 10, 'Start Date : ' . $sdate, 1);
    $pdf->Cell(95, 10, 'End Date : ' . $edate, 1, 1);

    $extraInfo = "Report Date : " . date("d-m-Y") . "\n";

    $pdf->MultiCell(95, 10, $extraInfo, 0);
    $pdf->Ln(10);

    // Items Table Header
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(10, 10, 'Sr.', 1);
    $pdf->Cell(70, 10, 'Product Name', 1);
    $pdf->Cell(20, 10, 'Qty', 1);
    $pdf->Cell(30, 10, 'Total Amount', 1);
    $pdf->Cell(30, 10, 'Date', 1, 1);

    // Items Data
    $i = 1;
    $query = "select purchase.id,product.product_name,purchase.qty,purchase.total_cost,purchase.time from purchase,product where purchase.user_id='$user_ID' AND product.id = purchase.p_id AND purchase.time>='$sdate' AND purchase.time<='$edate'";
    $product_show_result = mysqli_query($con, $query);
    while ($val = mysqli_fetch_row($product_show_result)) {
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 10, $i, 1);
        $pdf->Cell(70, 10, $val[1], 1);
        $pdf->Cell(20, 10, $val[2], 1);
        $pdf->Cell(30, 10, number_format($val[3]), 1);
        $pdf->Cell(30, 10, $val[4], 1, 1);
        $i++;
    }

    $pdf->Output("D", $sdate . " to " . $edate . "purchase.pdf");
}

if (isset($_POST['sales_btn_pdf'])) {
    $sdate = $_POST['start_date'];
    $edate = $_POST['end_date'];
    $user_ID = $_POST['userID'];
    $pdf = new FPDF();
    $pdf->AddPage();

    // Add Logo
    $pdf->Image('..\assets\images\favicon-32x32.png', 10, 6, 30);

    // Company Details
    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(80);
    $pdf->Cell(30, 10, 'MARUTI FABRICS', 0, 1, 'C');

    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(0, 10, 'Plot No. 20-21/A, Sahaj Ind. Society, Bamroli, Surat.', 0, 1, 'C');
    $pdf->Cell(0, 2, 'Mobile: 9328210985   GSTIN: 24BCOPP6008E1ZN', 0, 1, 'C');
    $pdf->Ln(5);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Purchase Report', 0, 1, 'C');
    $pdf->Ln(5);

    $billNo = $_SESSION['bill_no'];
    // Invoice Details
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(95, 10, 'Start Date : ' . $sdate, 1);
    $pdf->Cell(95, 10, 'End Date : ' . $edate, 1, 1);

    $extraInfo = "Report Date : " . date("d-m-Y") . "\n";

    $pdf->MultiCell(95, 10, $extraInfo, 0);
    $pdf->Ln(10);

    // Items Table Header
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(10, 10, 'Sr.', 1);
    $pdf->Cell(70, 10, 'Product Name', 1);
    $pdf->Cell(20, 10, 'Qty', 1);
    $pdf->Cell(30, 10, 'Unit Price', 1);
    $pdf->Cell(30, 10, 'Total', 1);
    $pdf->Cell(30, 10, 'Date', 1, 1);

    // Items Data
    $i = 1;
    $total = 0;
    $query = "select product_name,product_qty,product_price,total,date from billing_details where user_id='$user_ID' AND date>='$sdate' AND date<='$edate'";
    $product_show_result = mysqli_query($con, $query);
    while ($val = mysqli_fetch_row($product_show_result)) {
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 10, $i, 1);
        $pdf->Cell(70, 10, $val[0], 1);
        $pdf->Cell(20, 10, $val[1], 1);
        $pdf->Cell(30, 10, number_format($val[2]), 1);
        $pdf->Cell(30, 10, number_format($val[3]), 1);
        $pdf->Cell(30, 10, $val[4], 1, 1);
        $total = $total + $val[3];
        $i++;
    }

    $pdf->Cell(10, 10, '', 0);
    $pdf->Cell(70, 10, '', 0);
    $pdf->Cell(20, 10, '', 0);
    $pdf->Cell(30, 10, 'Total sale', 1);
    $pdf->Cell(30, 10, number_format($total), 1);

    // $pdf->SetFont('Arial', 'B', 20);

    // $pdf->Cell(71, 10, '', 0, 0);
    // $pdf->Cell(59, 5, 'Sales Report', 0, 0);
    // $pdf->Cell(59, 10, '', 0, 1);

    // $pdf->SetFont('Arial', 'B', 15);
    // $pdf->Cell(71, 5, '', 0, 0);
    // $pdf->Cell(59, 5, '', 0, 0);
    // $pdf->Cell(59, 5, '', 0, 1);

    // $pdf->SetFont('Courier', '', 12);

    // $pdf->Cell(25, 9, 'From: ' . $sdate, 0, 0);
    // $pdf->Cell(34, 9, '', 0, 1);

    // $pdf->Cell(25, 9, 'To:   ' . $edate, 0, 0);
    // $pdf->Cell(34, 9, '', 0, 1);

    // $pdf->Cell(130, 9, '', 0, 0);
    // $pdf->Cell(25, 1, 'Report Date:  ' . date("d-m-Y"), 0, 0);
    // $pdf->Cell(34, 1, '', 0, 1);

    // $pdf->SetFont('Arial', 'B', 10);
    // $pdf->Cell(189, 10, '', 0, 1);

    // $pdf->Cell(50, 10, '', 0, 1);

    // $pdf->SetFont('Courier', 'B', 12);
    // $pdf->Cell(10, 6, 'Sr', 0, 0, 'C');
    // $pdf->Cell(60, 6, 'Product Name', 0, 0, 'C');
    // $pdf->Cell(15, 6, 'Qty', 0, 0, 'C');
    // $pdf->Cell(32, 6, 'Unit Price', 0, 0, 'C');
    // $pdf->Cell(35, 6, 'Total', 0, 0, 'C');
    // $pdf->Cell(45, 6, 'Date', 0, 1, 'C');
    // $pdf->SetFont('Courier', '', 12);
    // $i = 1;

    // $query = "select product_name,product_qty,product_price,total,date from billing_details where user_id='$user_ID' AND date>='$sdate' AND date<='$edate'";
    // $product_show_result = mysqli_query($con, $query);
    // while ($val = mysqli_fetch_row($product_show_result)) {
    //     $pdf->Cell(10, 6, $i, 0, 0, 'C');
    //     $pdf->Cell(60, 6, $val[0], 0, 0, 'C');
    //     $pdf->Cell(15, 6, $val[1], 0, 0, 'C');
    //     $pdf->Cell(32, 6, $val[2], 0, 0, 'C');
    //     $pdf->Cell(35, 6, $val[3], 0, 0, 'C');
    //     $pdf->Cell(45, 6, $val[4], 0, 1, 'C');
    //     $i++;
    // }


    // $pdf->Line(10, 50, 200, 50);

    $pdf->Output("D", $sdate . " to " . $edate . " sales.pdf");
}

if (isset($_POST['return_btn_pdf'])) {
    $sdate = $_POST['start_date'];
    $edate = $_POST['end_date'];
    $user_ID = $_POST['userID'];
    $pdf = new FPDF();
    $pdf->AddPage();

    $pdf->SetFont('Arial', 'B', 20);

    $pdf->Cell(71, 10, '', 0, 0);
    $pdf->Cell(59, 5, 'Return Report', 0, 0);
    $pdf->Cell(59, 10, '', 0, 1);

    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(71, 5, '', 0, 0);
    $pdf->Cell(59, 5, '', 0, 0);
    $pdf->Cell(59, 5, '', 0, 1);

    $pdf->SetFont('Courier', '', 12);

    $pdf->Cell(25, 9, 'From: ' . $sdate, 0, 0);
    $pdf->Cell(34, 9, '', 0, 1);

    $pdf->Cell(25, 9, 'To:   ' . $edate, 0, 0);
    $pdf->Cell(34, 9, '', 0, 1);

    $pdf->Cell(130, 9, '', 0, 0);
    $pdf->Cell(25, 1, 'Report Date:  ' . date("d-m-Y"), 0, 0);
    $pdf->Cell(34, 1, '', 0, 1);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(189, 10, '', 0, 1);

    $pdf->Cell(50, 10, '', 0, 1);

    $pdf->SetFont('Courier', 'B', 12);
    $pdf->Cell(10, 6, 'Sr', 0, 0, 'C');
    $pdf->Cell(40, 6, 'Product Name', 0, 0, 'C');
    $pdf->Cell(15, 6, 'Qty', 0, 0, 'C');
    $pdf->Cell(32, 6, 'Unit Price', 0, 0, 'C');
    $pdf->Cell(30, 6, 'Total', 0, 0, 'C');
    $pdf->Cell(35, 6, 'Customer Name', 0, 0, 'C');
    $pdf->Cell(30, 6, 'Date', 0, 1, 'C');
    $pdf->SetFont('Courier', '', 12);
    $i = 1;

    $query = "select product_name,qty,price,total,customer_name,date from product_return where user_id='$user_ID' AND date>='$sdate' AND date<='$edate'";
    $product_show_result = mysqli_query($con, $query);
    while ($val = mysqli_fetch_row($product_show_result)) {
        $pdf->Cell(10, 6, $i, 0, 0, 'C');
        $pdf->Cell(40, 6, $val[0], 0, 0, 'C');
        $pdf->Cell(15, 6, $val[1], 0, 0, 'C');
        $pdf->Cell(32, 6, $val[2], 0, 0, 'C');
        $pdf->Cell(30, 6, $val[3], 0, 0, 'C');
        $pdf->Cell(35, 6, $val[4], 0, 0, 'C');
        $pdf->Cell(30, 6, $val[5], 0, 1, 'C');
        $i++;
    }


    $pdf->Line(10, 50, 200, 50);

    $pdf->Output("D", $sdate . " to " . $edate . " return.pdf");
}
