<?php
ob_start();
include('header.php');
session_start();
if (!isset($_COOKIE['email']) && !isset($_COOKIE['pass'])) {
    header("Location: http://localhost/newproject/login/index.php");
    exit;
}
?>

<div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner mb-4">
        <div class="carousel-item active">
            <div class="page-header min-vh-75 m-3 border-radius-xl" style="background-image: url('assets/images/1.png');">
                <span class="mask bg-gradient-dark"></span>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 my-auto">
                            <h1 class="text-white fadeIn2 fadeInBottom">Purchase</h1>
                            <p class="lead text-white opacity-8 fadeIn3 fadeInBottom">Automate procurement, streamline stock intake, and optimize inventory with our advanced purchase module.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="page-header min-vh-75 m-3 border-radius-xl" style="background-image: url('assets/images/2.png');">
                <span class="mask bg-gradient-dark"></span>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 my-auto">
                            <h1 class="text-white fadeIn2 fadeInBottom">Sales</h1>
                            <p class="lead text-white opacity-8 fadeIn3 fadeInBottom">Maximize sales efficiency with our inventory management system's comprehensive sales tracking capabilities.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="page-header min-vh-75 m-3 border-radius-xl" style="background-image: url('assets/images/3.png');">
                <span class="mask bg-gradient-dark"></span>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 my-auto">
                            <h1 class="text-white fadeIn2 fadeInBottom">Return</h1>
                            <p class="lead text-white opacity-8 fadeIn3 fadeInBottom">Simplify returns, enhance accuracy, and optimize inventory control with our robust return module.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="min-vh-75 position-absolute w-100 top-0">
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon position-absolute bottom-50" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon position-absolute bottom-50" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </a>
    </div>
</div>

<?php include('footer.php'); ?>