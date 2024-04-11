<?php
include('conn.php');
session_start();

if (isset($_POST['login_btn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "select * from admin where email='$email'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_row($result);
    if ($row > 0) {
        $admin_email = $row[1];
        $admin_password = $row[2];
        if ($email == $admin_email) {
            if ($password == $admin_password) {
                $_SESSION['email'] = $email;
                $_SESSION['pass'] = $password;
                $_SESSION['icon'] = "success";
                $_SESSION['text'] = "Login Successfully";
                header("Location:http://localhost/newproject/admin/signin.php");
                exit();
            } else {
                $_SESSION['email'] = $email;
                $_SESSION['pass'] = '';
                $_SESSION['icon'] = "error";
                $_SESSION['text'] = "Password Incorrect...";
                header("Location:http://localhost/newproject/admin/signin.php");
                exit();
            }
        } else {
            $_SESSION['email'] = '';
            $_SESSION['pass'] = '';
            $_SESSION['icon'] = "error";
            $_SESSION['text'] = "Email Incorrect...";
            header("Location:http://localhost/newproject/admin/signin.php");
            exit();
        }
    } else {
        $_SESSION['email'] = '';
        $_SESSION['pass'] = '';
        $_SESSION['icon'] = "error";
        $_SESSION['text'] = "Email Not Found...";
        header("Location:http://localhost/newproject/admin/signin.php");
        exit();
    }
}
