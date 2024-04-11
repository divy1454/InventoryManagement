<?php
ob_start();
include('header.php');
include('command/conn.php');
session_start();
if (!isset($_COOKIE['email']) && !isset($_COOKIE['pass'])) {
    header("Location:http://localhost/newproject/admin/signin.php");
    exit();
}
?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>

<div class="container-fluid pt-4 px-4">
    <!-- Modal Start For View Feedback -->
    <!-- <div class="modal fade" id="edit_product" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Sr.</label>
                        <input type="text" class="form-control" id="sr" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <input type="text" class="form-control" id="mess" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Star</label>
                        <input type="number" readonly class="form-control" id="stardata" style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                        <div id="rateYo" data-rateyo-full-star="true" data-rating="$('#stardata').val()"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">User Name</label>
                        <input type="text" class="form-control" id="uname" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Modal End For View Feedback -->

    <div class="col-12">
        <div class="bg-light rounded h-100 p-4">
            <h2 class="mb-4 text-center">User Feedback's</h2>
            <?php
            $query = "select feedback.id,feedback.text,feedback.star,feedback.user_ID,user.username from feedback,user where user.id=feedback.user_ID";
            $result = mysqli_query($con, $query);
            while ($row = mysqli_fetch_row($result)) {
            ?>
                <div class="media">
                    <div class="media-body">
                        <b> Sr : </b><?php echo $row[0]; ?>
                        <br>
                        <b> User Name : </b>
                        <?php echo $row[4]; ?>
                        <br>
                        <b> Message : </b>
                        <p><?php echo $row[1]; ?></p>
                        <div class="rateYo-<?php echo $row[0]; ?>" data-rateyo-full-star="true"></div><br>
                        <script>
                            $('.rateYo-<?php echo $row[0]; ?>').rateYo({
                                fullStar: true,
                                rating: <?php echo $row[2]; ?>,
                                readOnly: true
                            });
                        </script>
                        <hr>
                    </div>
                </div>
            <?php }
            ?>
        </div>
    </div>
</div>

<?php include('footer.php') ?>