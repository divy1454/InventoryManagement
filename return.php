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

$email = $_COOKIE['email'];

$query_uid = "select id from user where email='$email'";
$result = mysqli_query($con, $query_uid);
$row = mysqli_fetch_row($result);
if ($row >= 0) {
    $u_id = $row[0];
} else {
    echo "User ID Not found";
}

if (isset($_GET['r_bno'])) {
    $bNo = $_GET['r_bno'];
} else {
    echo "";
}

$query_bill = "select customer_name,date,bill_no from billing_header where bill_no='$bNo' AND user_id='$u_id'";
$result_bill = mysqli_query($con, $query_bill);
while ($row = mysqli_fetch_row($result_bill)) {
    $cname = $row[0];
    $date = $row[1];
    $billNo = $row[2];
}
?>


<!-- Invoice 1 - Bootstrap Brain Component -->
<!-- <div class="container-fluid vh-100 h-100">
    <div class="row min-vh-80 h-100">
        <div class="col-12">
            <div class="table_data">
                <div class="container mt-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <section class="py-3 py-md-5">
                                    <div class="container">
                                        <div class="row justify-content-center">
                                            <div class="col-12 col-lg-9 col-xl-8 col-xxl-7">
                                                <div class="row gy-3 mb-3">
                                                    <h2 class="text-uppercase" style="text-align: center;">Invoice</h2>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-12 col-sm-6 col-md-8">
                                                        <h4>Customer Details</h4>
                                                        <address>
                                                            <strong>Name : Harsh Patel</strong><br>
                                                        </address>
                                                    </div>
                                                    <div class="col-12 col-sm-6 col-md-4">
                                                        <h4 class="row"> Invoice Details
                                                            <span class="col-6">Invoice Details</span>
                                                    <span class="col-6 text-sm-end">INT-001</span>
                                                        </h4>
                                                        <div class="row">
                                                            <span class="col-6">Date:</span>
                                                            <span class="col-6 text-sm-end">22-03-2024</span>
                                                            <span class="col-6">Bill No : </span>
                                                            <span class="col-6 text-sm-end">00005</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col" class="text-uppercase">Qty</th>
                                                                        <th scope="col" class="text-uppercase">Product</th>
                                                                        <th scope="col" class="text-uppercase text-end">Unit Price</th>
                                                                        <th scope="col" class="text-uppercase text-end">Amount</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="table-group-divider">
                                                                    <?php
                                                                    $i = 1;
                                                                    $query_bill_detail = "select product_name,product_qty,product_price,total from billing_details where bill_no=''";
                                                                    $result_bill_detail = mysqli_query($con, $query_bill_detail);
                                                                    while ($val = mysqli_fetch_row($result_bill_detail)) {
                                                                    }
                                                                    ?>
                                                                    <tr>
                                                                        <th scope="row">2</th>
                                                                        <td>Console - Bootstrap Admin Template</td>
                                                                        <td class="text-end">75</td>
                                                                        <td class="text-end">150</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->

<?php if (isset($billNo)) { ?>
    <div class="container-fluid vh-100 h-100">
        <div class="row min-vh-80 h-100">
            <div class="col-12">
                <!-- Modal start For Add Supplier_Return -->
                <!-- <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Add Return Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="./command/supplier_return_sql.php" method="post">
                                <div class="mb-3">
                                    <label class="form-label">User Email</label>
                                    <input type="text" value="<?php //echo $email; 
                                                                ?>" class="form-control" name="u_email" readonly style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">User ID</label>
                                    <input type="text" value="<?php //echo $u_id; 
                                                                ?>" class="form-control" name="u_id" id="user_id" readonly style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Product Name</label>
                                    <select class="form-select" name="prod_name" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                        <option value="">Select Product</option>
                                        <?php //while ($row_prod_name = mysqli_fetch_row($result_prod_name)) { 
                                        ?>
                                            <option value="<?php //echo $row_prod_name[0]; 
                                                            ?>"><?php //echo $row_prod_name[0]; 
                                                                ?></option>
                                        <?php //} 
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Supplier Name</label>
                                    <select class="form-select" name="supplier_name" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                        <option value="">Select Supplier</option>
                                        <?php //while ($row_supplier_name = mysqli_fetch_row($result_supplier_name)) { 
                                        ?>
                                            <option value="<?php //echo $row_supplier_name[0]; 
                                                            ?>"><?php //echo $row_supplier_name[0]; 
                                                                ?></option>
                                        <?php //} 
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Qty</label>
                                    <input type="number" class="form-control" name="p_qty" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <input type="submit" name="btn_s_return_add" class="btn btn-primary" value="Add">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div> -->
                <!-- Modal End For Add Supplier_Return -->

                <!-- Table Start -->
                <div class="table_data">
                    <div class="container mt-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="table-responsive">
                                        <div class="card-header">
                                            <h4 style="text-align: center;">Product Details</h4>
                                            <hr class="horizontal dark mt-0 mb-4" style="opacity: 100;">
                                            <!-- <br> -->
                                            <div class="float-center">
                                                <div class=" row mb-4">
                                                    <div class="col-12 col-sm-6 col-md-8">
                                                        <h4>Customer Details</h4>
                                                        <address>
                                                            <strong>Name : <?php echo $cname; ?></strong><br>
                                                        </address>
                                                    </div>
                                                    <div class="col-12 col-sm-6 col-md-4">
                                                        <h4 class="row">Invoice Details</h4>
                                                        <div class="row">
                                                            <span class="col-6 ">Date : <?php echo $date = strstr($date, ' ', true); ?></span>
                                                            <!-- <span class="col-3 text-sm-end">22-03-2024</span> -->
                                                            <span class="col-6 text-sm-end"></span>
                                                            <span class="col-6">Bill No : <?php echo $billNo; ?></span>
                                                            <!-- <span class="col-6 text-sm-end"></span> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <!-- <br> -->
                                            <!-- <table id="table_data_search" class="table table-bordered table-striped"> -->
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>Sr</th>
                                                        <th>Product Name</th>
                                                        <th>Qty</th>
                                                        <th>Price</th>
                                                        <th>Total</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    $query_bill_detail = "select product_name,product_qty,product_price,total,bill_no from billing_details where bill_no='$billNo'";
                                                    $result_bill_detail = mysqli_query($con, $query_bill_detail);
                                                    while ($val = mysqli_fetch_row($result_bill_detail)) {
                                                        echo "<tr class='text-center'>";
                                                        echo "<td>" . $i . "</td>";
                                                        echo "<td>" . $val[0] . "</td>";
                                                        echo "<td>" . $val[1] . "</td>";
                                                        echo "<td>" . $val[2] . "</td>";
                                                        echo "<td>" . $val[3] . "</td>";
                                                        echo "<td><a href='class.php?b_no=$val[4]&pname=$val[0]'><button type='button' name='view_btn' class='btn btn-warning btn-sm view'><i class='material-icons opacity-10' style='font-size: large;'>refresh</i></button></a></td>";
                                                        echo "</tr>";
                                                        $i = $i + 1;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
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

                <script>
                    $(document).ready(function() {
                        $('#table_data_search').DataTable({
                            "lengthMenu": [
                                [5, 10, 15, -1],
                                [5, 10, 15, "All"]
                            ],
                            responsive: true,
                            language: {
                                paginate: {
                                    next: '&#8594;',
                                    previous: '&#8592;'
                                },
                                search: "_INPUT_",
                                searchPlaceholder: "Search",
                            }
                        });
                    });

                    function getbprice(pname) {
                        var uid = $('#user_id').val();
                        $.ajax({
                            url: 'class.php',
                            type: 'POST',
                            data: {
                                p_name: pname,
                                u_id: uid
                            },
                            success: function(results) {
                                $('#bprice').attr("value", results);
                            }
                        })
                    }
                </script>
                <!-- Main Content End -->
            </div>
        </div>
    </div>
<?php } else {
?>
    <script>
        Swal.fire({
            icon: 'error',
            text: 'Something Wrong!',
            showConfirmButton: false,
            timer: 2000,
            toast: true,
            position: "top",
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        }).then(function() {
            window.location.href = "http://localhost/newproject/billing.php";
        });
    </script>
<?php
} ?>

<?php include('footer.php'); ?>