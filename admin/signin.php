<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DASHMIN - Bootstrap Admin Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon-32x32.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <!-- CDN Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    session_start();
    if (isset($_SESSION['text']) && $_SESSION['text'] != '') {
        if (isset($_SESSION['text']) && $_SESSION['text'] == 'Login Successfully') {
            setcookie("email", $_SESSION['email'], time() + 3600 * 24, "/");
            setcookie("pass", $_SESSION['pass'], time() + 3600 * 24, "/");
    ?>
            <script>
                Swal.fire({
                    icon: '<?php echo $_SESSION['icon']; ?>',
                    text: '<?php echo $_SESSION['text']; ?>',
                    showConfirmButton: false,
                    timer: 2500,
                    toast: true,
                    position: "top",
                }).then(function() {
                    window.location.href = "http://localhost/newproject/admin/";
                    exit();
                });
            </script>
        <?php
            unset($_SESSION['text']);
        } else {
        ?>
            <script>
                Swal.fire({
                    icon: '<?php echo $_SESSION['icon']; ?>',
                    text: '<?php echo $_SESSION['text']; ?>',
                    showConfirmButton: false,
                    timer: 2700,
                    toast: true,
                    position: "top",
                });
            </script>
    <?php
            unset($_SESSION['text']);
        }
    }
    ?>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <!-- <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div> -->
        <!-- Spinner End -->


        <!-- Sign In Start -->

        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <form action="command/signin_sql.php" method="post">
                        <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <a href="index.html" class="">
                                    <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>ADMIN</h3>
                                </a>
                                <h3>Login</h3>
                            </div>
                            <div class="form-floating mb-3">
                                <?php if (isset($_SESSION['email'])) { ?>
                                    <input type="email" class="form-control" value="<?php echo $_SESSION['email']; ?>" name="email" id="floatingInput" placeholder="name@example.com">
                                <?php unset($_SESSION['email']);
                                } else {
                                ?>
                                    <input type="email" class="form-control" value="" name="email" id="floatingInput" placeholder="name@example.com">
                                <?php
                                } ?>
                                <label for="floatingInput">Email address</label>
                            </div>
                            <div class="form-floating mb-4">
                                <?php if (isset($_SESSION['pass'])) { ?>
                                    <input type="password" value="<?php echo $_SESSION['pass']; ?>" class="form-control" name="password" id="floatingPassword" placeholder="Password">
                                <?php unset($_SESSION['pass']);
                                } else {
                                ?>
                                    <input type="password" value="" class="form-control" name="password" id="floatingPassword" placeholder="Password">
                                <?php
                                } ?>
                                <label for="floatingPassword">Password</label>
                            </div>
                            <button type="submit" name="login_btn" class="btn btn-primary py-3 w-100 mb-4">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>