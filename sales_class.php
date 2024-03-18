<?php
ob_start();
include('command/conn.php');
session_start();
// session_destroy();

if (isset($_POST['p_name']) && isset($_POST['p_id']) && isset($_POST['c_name']) && isset($_POST['p_qty']) && isset($_POST['p_price']) && isset($_POST['p_total'])) {
    $id = $_POST['p_id'];
    $_SESSION['cname'] = $_POST['c_name'];
    if (isset($_SESSION['sales'][$id])) {
        $old = $_SESSION['sales'][$id]['qty'];
        $_SESSION['sales'][$id] = array("pid" => $id, "pname" => $_POST['p_name'], "qty" => $old + $_POST['p_qty'], "price" => $_POST['p_price'], "total" => $_POST['p_price'] * ($old + $_POST['p_qty']));
    } else {
        $_SESSION['sales'][$id] = array("pid" => $id, "pname" => $_POST['p_name'], "qty" => $_POST['p_qty'], "price" => $_POST['p_price'], "total" => $_POST['p_total']);
    }
}


if (isset($_POST['action'])) {
    $pName = $_POST['p__name'];

    foreach ($_SESSION['sales'] as $key => $val) {
        if ($val['pname'] == $pName) {
            $ID = $val['pid'];
            unset($_SESSION['sales'][$key]);
            $_SESSION['sales'] = array_values($_SESSION['sales']);
        }
    }
}
