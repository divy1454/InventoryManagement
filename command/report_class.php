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
if (isset($_POST['s_d']) && isset($_POST['e_d']) && isset($_POST['u_id']) && $_POST['action'] == 'purchase_pdf') {
    $sdate = $_POST['s_d'];
    $edate = $_POST['e_d'];
    $pdf = new FPDF();
    $pdf->AddPage();

    $pdf->SetFont('Arial', 'B', 20);

    $pdf->Cell(71, 10, '', 0, 0);
    $pdf->Cell(59, 5, 'Purchase Report', 0, 0);
    $pdf->Cell(59, 10, '', 0, 1);

    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(71, 5, 'Customer Details', 0, 0);
    $pdf->Cell(59, 5, '', 0, 0);
    $pdf->Cell(59, 5, 'Invoice Details', 0, 1);

    $pdf->SetFont('Courier', '', 12);

    $pdf->Cell(130, 9, 'Name : ', 0, 0);
    // $pdf->Cell(25, 5, 'Customer:', 0, 0);
    // $pdf->Cell(34, 5, 'ABC', 0, 1);

    // $pdf->Cell(130, 5, 'Delhi, 751001', 0, 0);
    $pdf->Cell(25, 9, 'Date:', 0, 0);
    $pdf->Cell(34, 9, date("d-m-Y"), 0, 1);

    $pdf->Cell(130, 9, '', 0, 0);
    $pdf->Cell(25, 1, 'Bill No:', 0, 0);
    $pdf->Cell(34, 1, '00004', 0, 1);


    // $pdf->SetFont('Arial', 'B', 15);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(189, 10, '', 0, 1);

    $pdf->Cell(50, 10, '', 0, 1);

    $pdf->SetFont('Courier', 'B', 12);
    $pdf->Cell(10, 6, 'Sr', 0, 0, 'C');
    $pdf->Cell(80, 6, 'Product Name', 0, 0, 'C');
    $pdf->Cell(23, 6, 'Qty', 0, 0, 'C');
    $pdf->Cell(30, 6, 'Total', 0, 0, 'C');
    $pdf->Cell(25, 6, 'Date', 0, 1, 'C');
    $pdf->SetFont('Courier', '', 12);
    $i = 1;

    $query = "select purchase.id,product.product_name,purchase.qty,purchase.total_cost,purchase.time from purchase,product where purchase.user_id='$user_ID' AND product.id = purchase.p_id AND purchase.time>='$sdate' AND purchase.time<='$edate'";
    $product_show_result = mysqli_query($con, $query);
    while ($val = mysqli_fetch_row($product_show_result)) {
        $pdf->Cell(10, 6, $i, 0, 0, 'C');
        $pdf->Cell(80, 6, $val[1], 0, 0, 'C');
        $pdf->Cell(23, 6, $val[2], 0, 0, 'C');
        $pdf->Cell(30, 6, $val[3], 0, 0, 'C');
        $pdf->Cell(25, 6, $val[4], 0, 1, 'C');
        $i++;
    }


    $pdf->Cell(118, 6, '', 0, 0);
    $pdf->Cell(25, 6, 'Total', 1, 0, 'C');
    $pdf->Cell(25, 6, '123', 1, 1, 'C');

    $pdf->Line(10, 61, 178, 61);

    $pdf->Output("D", "001.pdf");
}
