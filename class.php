<?php
include('command/conn.php');
require('fpdf/fpdf.php');
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

if (isset($_POST['gst_pname']) && isset($_POST['gst_uid'])) {
    $productName = $_POST['gst_pname'];
    $uid = $_POST['gst_uid'];

    $q = "select gst from product where product_name='$productName' AND user_id='$uid'";
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

if (isset($_POST['PName']) && isset($_POST['UId'])) {
    $productName = $_POST['PName'];
    $uid = $_POST['UId'];

    $q = "select qty from product where product_name='$productName' AND user_id='$uid'";
    $result = mysqli_query($con, $q);
    while ($row = mysqli_fetch_row($result)) {
        echo $row[0];
    }
}

if (isset($_SESSION['cname'])) {
    $cid = $_SESSION['cname'];
    $query_cname = "select c_name,c_add,c_phone from customer where id='$cid'";
    $result_c_name = mysqli_query($con, $query_cname);
    while ($row_c_name = mysqli_fetch_row($result_c_name)) {
        $c_name = $row_c_name[0];
        $c_add = $row_c_name[1];
        $c_phone = $row_c_name[2];
    }
}


// Create a bill as PDF
if (isset($_POST['btn_bill'])) {
    if (isset($_SESSION['sales']) && count($_SESSION['sales']) != 0) {
        date_default_timezone_set("Asia/Kolkata");
        $date = date("Y-m-d");
        $cname = $c_name;
        $bill_no = $_SESSION['bill_no'];
        $query = "insert into billing_header(customer_name,date,bill_no,user_id) values('$cname','$date','$bill_no','$user_ID')";
        $result_insert_bill = mysqli_query($con, $query);
        foreach ($_SESSION['sales'] as $key => $val) {
            $pname = $val['pname'];
            $pqty = $val['qty'];
            $pprice = $val['price'];
            $ptotal = $val['total'];
            $gst_amount = $val['gst'];
            $query_insert_bill_details = "insert into billing_details(bill_no,product_name,product_qty,product_price,gst_amount,date,total,user_id) values('$bill_no','$pname','$pqty','$pprice','$gst_amount','$date','$ptotal','$user_ID')";
            $result_bill_details = mysqli_query($con, $query_insert_bill_details);
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
        $pdf->Cell(95, 10, 'Invoice No.: ' . $billNo, 1);
        $pdf->Cell(95, 10, 'Invoice Date: ' . date("d-m-Y"), 1, 1);
        $pdf->Cell(95, 10, 'Bill To :', 1);
        $pdf->Cell(95, 10, 'Ship To :', 1, 1);

        // Customer Information
        $pdf->SetFont('Arial', '', 10);
        $customerInfo = "Customer Name : " . $c_name . "\n";
        $customerInfo .= "Address : " . $c_add . "\n";

        $extraInfo = "Mobile: " . $c_phone . "\n";

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
        foreach ($_SESSION['sales'] as $key => $val) {
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(10, 10, $i, 1);
            $pdf->Cell(60, 10, $val['pname'], 1);
            $pdf->Cell(20, 10, $val['qty'], 1);
            $pdf->Cell(30, 10, number_format($val['price']), 1);
            $pdf->Cell(30, 10, number_format($val['gst']) . " (" . ($val['gstper']) . ") ", 1);
            $pdf->Cell(30, 10, number_format($val['total']), 1, 1);
            $total = $total + $val['total'];
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

        $pdf->Output("D", $billNo . ".pdf");
        unset($_SESSION['sales']);
        unset($_SESSION['cname']);
    } else {
        $_SESSION['sale_message'] = "No any product add for Sale...";
        $_SESSION['icon'] = "error";
        $_SESSION['title'] = "Error...";
        header("Location: http://localhost/newproject/sales_extra.php");
        exit();
    }
}

// Product Delete and Insert into Return Table
if (isset($_GET['b_no']) && $_GET['pname']) {
    $bno = $_GET['b_no'];
    $pname = $_GET['pname'];
    $customer_name = $_GET['cname'];
    $query_get_pdetails = "select product_name,product_qty,product_price,total from billing_details where bill_no='$bno' AND product_name='$pname'";
    $result_get_ddetails = mysqli_query($con, $query_get_pdetails);
    while ($row = mysqli_fetch_row($result_get_ddetails)) {
        $productname = $row[0];
        $productQty = $row[1];
        $productPrice = $row[2];
        $total = $row[3];
    }

    date_default_timezone_set("Asia/Kolkata");
    $date = date("Y-m-d");
    $query_insert_return = "insert into product_return(product_name,qty,price,total,customer_name,date,user_id) values('$productname','$productQty','$productPrice','$total','$customer_name','$date','$user_ID')";
    $result_return = mysqli_query($con, $query_insert_return);

    $query_product_return = "update product set qty=qty+'$productQty' where product_name='$pname' AND user_id='$user_ID' ";
    $result_product_return = mysqli_query($con, $query_product_return);

    $query_delete = "delete from billing_details where bill_no='$bno' AND product_name='$pname' AND user_id='$user_ID'";
    $result_delete = mysqli_query($con, $query_delete);
    $delete = mysqli_affected_rows($con);
    if ($delete > 0) {
        $_SESSION['return_message'] = "Product Returned!";
        $_SESSION['icon'] = "success";
        header("Location: http://localhost/newproject/return.php?r_bno=" . $bno);
        exit();
    } else {
        $_SESSION['return_message'] = "Product Not Return! Please try again..";
        $_SESSION['icon'] = "error";
        header("Location: http://localhost/newproject/return.php?r_bno=" . $bno);
        exit();
    }
}
