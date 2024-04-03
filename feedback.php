<?php
ob_start();
include('header.php');
include('command/conn.php');
session_start();
if (!isset($_COOKIE['email']) && !isset($_COOKIE['pass'])) {
    header("Location: http://localhost/newproject/login/index.php");
    exit;
}

$email = $_COOKIE['email'];

$query_uid = "select id from user where email='$email'";
$result = mysqli_query($con, $query_uid);
$row = mysqli_fetch_row($result);
if ($row >= 0) {
    $u_id = $row[0];
} else {
    echo "User ID Not found";
}
?>


<div class="container-fluid vh-100 h-100">
    <div class="row min-vh-80 h-100">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Give Feedback</h4>
                </div>
                <div class="card-body">
                    <div class="container-wrapper">
                        <div class="container d-flex align-items-center justify-content-center">
                            <div class="row justify-content-center">
                                <div class="full-star-ratings" data-rateyo-full-star="true"></div>
                                <textarea class="mt-4" cols="20" rows="5" style="resize: none;"></textarea>
                            </div>
                        </div>
                        <div class="mt-4" style="align-items: center; text-align: center;">
                            <button type="button" class="btn btn-primary">
                                Give Feedback
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
<script>
    $('.full-star-ratings').rateYo({
        rating: 5
    });
    $('.full-star-ratings').click(function() {
        var $rateYo = $(".full-star-ratings").rateYo();
        var rating = $rateYo.rateYo("rating");

        window.alert("Its " + rating + " Yo!");
    });
</script>
<?php include('footer.php'); ?>