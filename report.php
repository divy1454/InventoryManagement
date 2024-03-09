<?php

ob_start();

// This is a header file include
include('header.php');
include('command/conn.php');
session_start();
if (!isset($_COOKIE['email']) && !isset($_COOKIE['pass'])) {
    header("Location: http://localhost/newproject/login/index.php");
    exit;
}

$date = $_POST['daterange'];

echo strstr($date, "to", true);
echo "<br>";
echo substr($date, 14);


?>

<form action="" method="post">
    <input type="text" id="calendar-selectrange" name="daterange">

</form>


<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr('#calendar-selectrange', {
        "mode": "range",
        "maxDate": "today"
    });
</script>

<?php include('footer.php'); ?>