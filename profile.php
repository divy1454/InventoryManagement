<?php
ob_start();
include('header.php');
session_start();
if (!isset($_COOKIE['email']) && !isset($_COOKIE['pass'])) {
    header("Location: http://localhost/newproject/login/index.php");
    exit;
}
?>
<style>
    .box {
        align-items: center;
        justify-content: center;
    }

    .btn-file {
        position: relative;
        overflow: hidden;
    }

    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        cursor: pointer;
        display: block;
    }
</style>


<form action="command/profile_sql.php" method="post" enctype="multipart/form-data">
    <div class="container rounded bg-white mt-0 mb-5">
        <div class="row box">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <img class="rounded-circle" id="profile" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">
                    <br>
                    <span class="btn btn-primary btn-file">Upload new image<input type="file" id="inputfile" accept="image/png, image/jpeg" name="profileimg" required></span>
                    <!-- <span class="font-weight-bold">UserName</span>
                    <span class="text-black-50">Email I'd</span> -->
                    <span> </span>
                </div>
            </div>
            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Details</h4>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <div class="input-group input-group-static">
                                <label class="labels">Username </label>
                                <input type="text" class="form-control" name="uname" required autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6 mt-2">
                            <div class="input-group input-group-static">
                                <label class="labels">First Name </label>
                                <input type="text" class="form-control" name="fname" required>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="input-group input-group-static">
                                <label class="labels">Last Name </label>
                                <input type="text" class="form-control" name="lname" required>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <br>
                            <div class="input-group input-group-static">
                                <label class="labels">Mobile Number </label>
                                <input type="text" class="form-control" name="phone" minlength="10" maxlength="10" required>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <br>
                            <div class="input-group input-group-static">
                                <label class="labels">Shop Name</label>
                                <input type="text" class="form-control" name="shop" required>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <br>
                            <div class="input-group input-group-static">
                                <label class="labels">Pincode</label>
                                <input type="text" class="form-control" name="pincode" minlength="6" maxlength="6" required>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <br>
                            <label class="labels">State </label>
                            <select class="form-select" name="state" style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                <option value="">Gujarat</option>
                                <option value="">Maharastra</option>
                                <option value="">Rajastan</option>
                            </select>
                        </div>
                        <div class="col-md-12 mt-2">
                            <br>
                            <div class="input-group input-group-static">
                                <label class="labels">Email ID</label>
                                <input type="text" class="form-control" value="hp004086@gmail.com" name="email" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="submit" name="update_btn">Save Changes</button></div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    let profilepic = document.getElementById("profile");
    let inputfile = document.getElementById("inputfile");

    inputfile.onchange = function() {
        profilepic.src = URL.createObjectURL(inputfile.files[0]);
    }
</script>

<?php include('footer.php'); ?>