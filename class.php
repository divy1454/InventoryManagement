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




if (isset($_POST['btn_bill'])) {
    if (isset($_SESSION['sales']) && count($_SESSION['sales']) != 0) {
        date_default_timezone_set("Asia/Kolkata");
        $date = date("Y-m-d h:i:sa", time());
        $cname = $_SESSION['cname'];
        $bill_no = $_SESSION['bill_no'];
        $query = "insert into billing_header(customer_name,date,bill_no,user_id) values('$cname','$date','$bill_no','$user_ID')";
        $result_insert_bill = mysqli_query($con, $query);
        foreach ($_SESSION['sales'] as $key => $val) {
            $pname = $val['pname'];
            $pqty = $val['qty'];
            $pprice = $val['price'];
            $ptotal = $val['total'];
            $query_insert_bill_details = "insert into billing_details(bill_no,product_name,product_qty,product_price,total,user_id) values('$bill_no','$pname','$pqty','$pprice','$ptotal','$user_ID')";
            $result_bill_details = mysqli_query($con, $query_insert_bill_details);
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

        $pdf->Cell(130, 9, 'Name : ' . $_SESSION['cname'], 0, 0);
        // $pdf->Cell(25, 5, 'Customer:', 0, 0);
        // $pdf->Cell(34, 5, 'ABC', 0, 1);

        // $pdf->Cell(130, 5, 'Delhi, 751001', 0, 0);
        $pdf->Cell(25, 9, 'Date:', 0, 0);
        $pdf->Cell(34, 9, date("d-m-Y"), 0, 1);

        $billNo = $_SESSION['bill_no'];
        $pdf->Cell(130, 9, '', 0, 0);
        $pdf->Cell(25, 1, 'Bill No:', 0, 0);
        $pdf->Cell(34, 1, $billNo, 0, 1);


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
        foreach ($_SESSION['sales'] as $key => $val) {
            $pdf->Cell(10, 6, $i, 0, 0, 'C');
            $pdf->Cell(80, 6, $val['pname'], 0, 0, 'C');
            $pdf->Cell(23, 6, $val['qty'], 0, 0, 'C');
            $pdf->Cell(30, 6, $val['price'], 0, 0, 'C');
            $pdf->Cell(25, 6, $val['total'], 0, 1, 'C');
            $total = $total + $val['total'];
            $i++;
        }


        $pdf->Cell(118, 6, '', 0, 0);
        $pdf->Cell(25, 6, 'Total', 1, 0, 'C');
        $pdf->Cell(25, 6, $total, 1, 1, 'C');

        $pdf->Line(10, 61, 178, 61);

        $pdf->Output("I", "001.pdf");
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


if (isset($_GET['b_no']) && $_GET['pname']) {
    $query_get_pdetails = "select product_name,product_qty,product_price,total from billing_details where bill_no='$_GET[b_no]' AND product_name='$_GET[pname]'";
    $result_get_ddetails = mysqli_query($con, $query_get_pdetails);
    while ($row = mysqli_fetch_row($result_bill_details)) {
        $productname = "";
    }
    $query = "insert into return(product_name,qty,price,total,user_id) values('','','','','')";
}
