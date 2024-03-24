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

// $date = $_POST['daterange'];

// echo strstr($date, "to", true);
// echo "<br>";
// echo substr($date, 14);
?>

<!-- <form action="" method="post">
    <input type="text" id="calendar-selectrange" name="daterange">

</form> -->

<div class="container-fluid vh-100 h-100">
    <div class="row min-vh-80 h-100">
        <div class="col-12">
            <!-- Main Content Start -->

            <!-- Table Start -->
            <div class="table_data">
                <div class="container mt-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="table-responsive">
                                    <div class="card-header">
                                        <h4>Product Sales</h4>

                                        <div class="row mt-3">
                                            <div class="col-md-3 mt-2">
                                                <label class="labels">Report Type </label>
                                                <select class="form-select" onchange="getbprice(this.value)" id="pname" name="prod_name" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                                    <option value="">Select Type</option>
                                                    <option value="purchase_report">Purchase Report</option>
                                                    <option value="sales_report">Sales Report</option>
                                                    <option value="return_report">Return Report</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mt-2">
                                                <label class="labels">Start Date </label>
                                                <input type="text" id="calendar-selectrange" name="daterange" placeholder="Please Select Start Date">
                                            </div>
                                            <div class="col-md-3 mt-2">
                                                <label class="labels">End Date </label>
                                                <input type="text" id="calendar-selectrange1" name="daterange" placeholder="Please Select End Date">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="float-end">
                                            <button type="button" class="btn btn-primary" id="btn_sales">
                                                Show Report
                                            </button>
                                        </div>
                                        <br>

                                        <div class="card-body">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Table End -->

                <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
                <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

                <!-- Main Content End -->
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // flatpickr('#calendar-selectrange', {
    //     "maxDate": "today",
    //     "dateFormat": "Y-m-d"
    // });
    const start_date = flatpickr("#calendar-selectrange", {
        dateFormat: 'Y-m-d',
        "maxDate": "today",
        onChange: function(sel_date, date_str) {
            end_date.set("minDate", date_str);
            end_date.set("maxDate", "today");
        }
    });

    const end_date = flatpickr("#calendar-selectrange1", {
        dateFormat: 'Y-m-d',
        "maxDate": "today"
    });
</script>

<?php include('footer.php'); ?>