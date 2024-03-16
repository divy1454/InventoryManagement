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

$query_prod_name = "select product_name,id from product where user_id='$u_id'";
$result_prod_name = mysqli_query($con, $query_prod_name);

$query_cname = "select c_name from customer where u_id='$u_id'";
$result_c_name = mysqli_query($con, $query_cname);
?>


<?php
// session_start();
if (isset($_SESSION['purchase_message']) && $_SESSION['purchase_message'] != '') {
    if (isset($_SESSION['purchase_message']) && $_SESSION['purchase_message'] == 'Product Added Successfully!') {
?>
        <script>
            Swal.fire({
                icon: '<?php echo $_SESSION['icon']; ?>',
                text: '<?php echo $_SESSION['purchase_message']; ?>',
                showConfirmButton: false,
                timer: 3000,
                toast: true,
                position: "top",
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
        </script>
    <?php
        unset($_SESSION['purchase_message']);
    } else {
    ?>
        <script>
            Swal.fire({
                icon: '<?php echo $_SESSION['icon']; ?>',
                text: '<?php echo $_SESSION['purchase_message']; ?>',
                showConfirmButton: false,
                timer: 2700,
                toast: true,
                position: "top",
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
        </script>
<?php
        unset($_SESSION['purchase_message']);
    }
}
?>

<div class="container-fluid vh-100 h-100">
    <div class="row min-vh-80 h-100">
        <div class="col-12">
            <!-- Main Content Start -->
            <!-- Modal start For Add Sales -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Add Sales</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="./command/sales_sql.php" method="post">
                                <div class="mb-3">
                                    <label class="form-label">User Email</label>
                                    <input type="text" value="<?php echo $email; ?>" class="form-control" name="u_email" readonly style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">User ID</label>
                                    <input type="text" value="<?php echo $u_id; ?>" class="form-control" name="u_id" id="user_id" readonly style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Product Name</label>
                                    <!-- <select class="form-select" onchange="getbprice(this.value)" name="prod_name" required style="border: 1px solid gray; padding:5px 5px 5px 5px;"> -->
                                    <!-- <option value="">Select Product</option> -->
                                    <?php //while ($row_prod_name = mysqli_fetch_row($result_prod_name)) { 
                                    ?>
                                    <!-- <option value="<?php //echo $row_prod_name[0]; 
                                                        ?>"><?php //echo $row_prod_name[0]; 
                                                            ?></option> -->
                                    <?php //} 
                                    ?>
                                    <!-- </select> -->
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Sell Price</label>
                                    <input type="text" class="form-control" name="s_price" id="sprice" value="" readonly style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Customer Name</label>
                                    <!-- <select class="form-select" name="c_name" required style="border: 1px solid gray; padding:5px 5px 5px 5px;"> -->
                                    <!-- <option value="">Select Customer</option> -->
                                    <?php //while ($row_c_name = mysqli_fetch_row($result_c_name)) { 
                                    ?>
                                    <!-- <option value="<?php //echo $row_c_name[0]; 
                                                        ?>"><?php //echo $row_c_name[0]; 
                                                            ?></option> -->
                                    <?php //} 
                                    ?>
                                    <!-- </select> -->
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Qty</label>
                                    <input type="number" class="form-control" name="s_qty" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <input type="submit" name="btn_sales_add" class="btn btn-primary" value="Add">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal End For Add Sales -->

            <!-- Table Start -->
            <div class="table_data">
                <div class="container mt-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="table-responsive">
                                    <div class="card-header">
                                        <h4>Product Sales
                                            <!-- <div class="float-end">
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                    Add Sales
                                                </button>
                                            </div> -->
                                        </h4>

                                        <div class="row mt-3">
                                            <div class="col-md-6 mt-2">
                                                <!-- <div class="input-group input-group-static"> -->
                                                <label class="labels">Product Name </label>
                                                <select class="form-select" onchange="getbprice(this.value)" id="p_name" name="prod_name" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                                    <option value="">Select Product</option>
                                                    <?php while ($row_prod_name = mysqli_fetch_row($result_prod_name)) { ?>
                                                        <option value="<?php echo $row_prod_name[0]; ?>"><?php echo $row_prod_name[0]; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <!-- </div> -->
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <div class="input-group input-group-static">
                                                    <label class="labels">Product ID </label>
                                                    <input type="text" class="form-control" name="fname" id="pid" style="font-weight: bold;">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <!-- <div class="input-group input-group-static"> -->
                                                <label class="labels">Customer Name </label>
                                                <select class="form-select" name="c_name" id="cname" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                                    <option value="">Select Customer</option>
                                                    <?php while ($row_c_name = mysqli_fetch_row($result_c_name)) {
                                                    ?>
                                                        <option value="<?php echo $row_c_name[0];
                                                                        ?>"><?php echo $row_c_name[0];
                                                                            ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                                <!-- </div> -->
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <div class="input-group input-group-static">
                                                    <label class="labels">Qty </label>
                                                    <input type="text" class="form-control" name="fname" id="pqty" style="font-weight: bold;">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <div class="input-group input-group-static">
                                                    <label class="labels">Price </label>
                                                    <input type="text" class="form-control" name="fname" id="pprice" style="font-weight: bold;">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <div class="input-group input-group-static">
                                                    <label class="labels">Total </label>
                                                    <input type="text" class="form-control" name="fname" id="ptotal" style="font-weight: bold;">
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="float-end">
                                            <button type="button" class="btn btn-primary" id="btn_sales">
                                                Add Sales
                                            </button>
                                        </div>
                                        <br>

                                        <div class="card-body">

                                            <table id="table_data_search" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>ID</th>
                                                        <th>Product Name</th>
                                                        <th>Qty</th>
                                                        <th>Price</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="result_data">
                                                    <?php
                                                    $i = 1;
                                                    foreach ($_SESSION['sales'] as $key => $val) {
                                                        echo "<tr>
                                                        <td>$i</td>
                                                        <td>$val[pname]</td>
                                                        <td>$val[qty]</td>
                                                        <td>$val[price]</td>
                                                        <td>$val[total]</td>
                                                    </tr>";
                                                        $i += 1;
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
                                pname: pname,
                                uid: uid
                            },
                            success: function(results) {
                                $('#sprice').attr("value", results);
                                $('#pprice').attr("value", results);
                                getID(pname);
                            }
                        })
                    }

                    function getID(pname) {
                        var uid = $('#user_id').val();
                        $.ajax({
                            url: 'class.php',
                            type: 'POST',
                            data: {
                                P_Name: pname,
                                U_Id: uid
                            },
                            success: function(results) {
                                $('#pid').attr("value", results);
                            }
                        })
                    }

                    $('#btn_sales').click(function() {
                        var pname = $('#pname').val();
                        var pid = $('#pid').val();
                        var cname = $('#cname').val();
                        var pqty = $('#pqty').val();
                        var pprice = $('#pprice').val();
                        var ptotal = $('#ptotal').val();

                        $.ajax({
                            url: 'sales_class.php',
                            type: 'POST',
                            data: {
                                p_name: pname,
                                p_id: pid,
                                c_name: cname,
                                p_qty: pqty,
                                p_price: pprice,
                                p_total: ptotal
                            },
                            success: function(data) {
                                location.reload();
                                // $('#result_data').html(data);
                            }
                        })
                    });

                    $("#pqty").keyup(function() {
                        var price = $("#pprice").val();
                        var pqty = $("#pqty").val();
                        $('#ptotal').val(price * pqty);
                    });
                </script>
                <!-- Main Content End -->
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>