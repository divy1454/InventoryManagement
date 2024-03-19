<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CDN Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
</body>

</html>
<?php
ob_start();
include('command/conn.php');
session_start();
// session_destroy();

if (isset($_POST['bill_no']) && isset($_POST['p_name']) && isset($_POST['p_id']) && isset($_POST['c_name']) && isset($_POST['p_qty']) && isset($_POST['p_price']) && isset($_POST['p_total'])) {
    $id = $_POST['p_id'];
    $pqty = $_POST['p_qty'];
    $u_email = $_COOKIE['email'];
    $prod_name = $_POST['p_name'];
    $_SESSION['cname'] = $_POST['c_name'];
    $_SESSION['pid'] = $id;
    $_SESSION['bill_no'] = $_POST['bill_no'];

    $query_uid = "select id from user where email='$u_email'";
    $result = mysqli_query($con, $query_uid);
    $row = mysqli_fetch_row($result);

    $query = "select id,profit,qty from product where product_name='$prod_name' AND user_id='$row[0]'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_row($result);
    $p_id = $row[0];
    $profit = $row[1];
    $p_qty = $row[2];

    if ($pqty <= $p_qty) {
        if (isset($_SESSION['sales'][$id])) {
            $old = $_SESSION['sales'][$id]['qty'];
            $_SESSION['sales'][$id] = array("pid" => $id, "pname" => $_POST['p_name'], "qty" => $old + $_POST['p_qty'], "price" => $_POST['p_price'], "total" => $_POST['p_price'] * ($old + $_POST['p_qty']));
            $update_query = "update product set qty=qty-'$pqty' where id='$id'";
            $update_result = mysqli_query($con, $update_query);
            $update_row = mysqli_affected_rows($con);
        } else {
            $_SESSION['sales'][$id] = array("pid" => $id, "pname" => $_POST['p_name'], "qty" => $_POST['p_qty'], "price" => $_POST['p_price'], "total" => $_POST['p_total']);
            $update_query = "update product set qty=qty-'$pqty' where id='$id'";
            $update_result = mysqli_query($con, $update_query);
            $update_row = mysqli_affected_rows($con);
        }
    } else {
        echo "<script>
        Swal.fire({
            icon: 'error',
            text: 'Quantity not available...',
            showConfirmButton: false,
            timer: 1500,
            toast: true,
            position: 'top',
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        </script>";
    }
}


if (isset($_POST['action'])) {
    $pName = $_POST['p__name'];

    foreach ($_SESSION['sales'] as $key => $val) {
        if ($val['pname'] == $pName) {
            $ID = $val['pid'];
            $pqty = $val['qty'];
            $update_query = "update product set qty=qty+'$pqty' where id='$ID'";
            $update_result = mysqli_query($con, $update_query);
            $update_row = mysqli_affected_rows($con);
            unset($_SESSION['sales'][$key]);
            $_SESSION['sales'] = array_values($_SESSION['sales']);
        }
    }
}
