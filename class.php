<?php
include('command/conn.php');
include('fpdf/fpdf.php');
session_start();
if (!isset($_COOKIE['email']) && !isset($_COOKIE['pass'])) {
    header("Location: http://localhost/newproject/login/index.php");
    exit;
}


if (isset($_POST['p_name']) && isset($_POST['u_id'])) {
    $productName = $_POST['p_name'];
    $uid = $_POST['u_id'];

    $q = "select buy_price from product where product_name='$productName' AND user_id='$uid'";
    $result = mysqli_query($con, $q);
    while ($row = mysqli_fetch_row($result)) {
        echo $row[0];
    }
}

if (isset($_POST['pname']) && isset($_POST['uid'])) {
    $productName = $_POST['pname'];
    $uid = $_POST['uid'];

    $q = "select sell_price from product where product_name='$productName' AND user_id='$uid'";
    $result = mysqli_query($con, $q);
    while ($row = mysqli_fetch_row($result)) {
        echo $row[0];
    }
}

if (isset($_POST['P_Name']) && isset($_POST['U_Id'])) {
    $productName = $_POST['P_Name'];
    $uid = $_POST['U_Id'];

    $q = "select id from product where product_name='$productName' AND user_id='$uid'";
    $result = mysqli_query($con, $q);
    while ($row = mysqli_fetch_row($result)) {
        echo $row[0];
    }
}


if (isset($_POST['btn_bill'])) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(40, 10, 'Customer Name :');
    $pdf->Ln(10);
    $pdf->Cell(40, 10, $_POST['c_name']);

    foreach ($_SESSION['sales'] as $key => $val) {
        $pdf->Cell(40, 10, $val['pname']);
        $pdf->Ln(10);
        $pdf->Cell(40, 10, $val['qty']);
        $pdf->Ln(10);
        $pdf->Cell(40, 10, $val['price']);
        $pdf->Ln(10);
        $pdf->Cell(40, 10, $val['total']);
        $pdf->Ln(10);
    }
    $pdf->Output("I", "001.pdf");

    unset($_SESSION['sales']);
}
