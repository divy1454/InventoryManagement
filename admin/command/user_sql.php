<?php
include('conn.php');

session_start();
if (isset($_POST['btn_user_edit'])) {
    $uid = $_POST['uid'];
    $shopname = $_POST['shopname'];
    $username = $_POST['username'];

    $sql = "update user set shopname='$shopname', username='$username' where id='$uid'";
    $result = mysqli_query($con, $sql);
    $update = mysqli_affected_rows($con);
    if ($update > 0) {
        $_SESSION['icon'] = "success";
        $_SESSION['message'] = "User Update Successfully!";
        header("Location: http://localhost/newproject/admin/user.php");
        exit();
    } else {
        $_SESSION['icon'] = "error";
        $_SESSION['message'] = "User Update Failed!";
        header("Location: http://localhost/newproject/admin/user.php");
        exit();
    }
}


if (isset($_POST['yes_btn'])) {
    $u_id = $_POST['delete_p_id'];
    $sql = "delete from user where id='$u_id'";
    $result = mysqli_query($con, $sql);
    $delete = mysqli_affected_rows($con);
    if ($delete > 0) {
        $_SESSION['icon'] = "success";
        $_SESSION['message'] = "User Deleted Successfully!";
        header("Location: http://localhost/newproject/admin/user.php");
        exit();
    } else {
        $_SESSION['icon'] = "error";
        $_SESSION['message'] = "User Delete Failed!";
        header("Location: http://localhost/newproject/admin/user.php");
        exit();
    }
}
