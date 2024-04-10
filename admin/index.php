<?php
include('header.php');
include('command/conn.php');

$query = "select * from user";
$result = mysqli_query($con, $query);
$row = mysqli_num_rows($result);
?>



<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <!-- <i class="fa fa-chart-line fa-3x text-primary"></i> -->
                <i class="fa fa-user-plus fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Total User's</p>
                    <h6 class="mb-0"><?php echo $row; ?></h6>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>