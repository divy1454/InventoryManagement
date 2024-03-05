<?php
ob_start();
include('header.php');
// session_start();
// if (!isset($_COOKIE['email']) && !isset($_COOKIE['pass'])) {
//     header("Location: http://localhost/newproject/login/index.php");
//     exit;
// }
?>



<script>
    let profilepic = document.getElementById("profile");
    let inputfile = document.getElementById("inputfile");

    inputfile.onchange = function() {
        profilepic.src = URL.createObjectURL(inputfile.files[0]);
    }
</script>

<?php include('footer.php'); ?>