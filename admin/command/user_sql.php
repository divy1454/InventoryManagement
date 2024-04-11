<?php
include('command/conn.php');

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


// Delete User Panding.....