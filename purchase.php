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
            <!-- Main Content Start -->
            <!-- Modal start For Add Product -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Add Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="./command/product_sql.php" method="post">
                                <div class="mb-3">
                                    <label class="form-label">User Email</label>
                                    <input type="text" value="<?php echo $email; ?>" class="form-control" name="u_email" readonly style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">User ID</label>
                                    <input type="text" value="<?php echo $u_id; ?>" class="form-control" name="u_id" readonly style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Product Name</label>
                                    <input type="text" class="form-control" name="p_name" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Qty</label>
                                    <input type="number" class="form-control" name="p_qty" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Mode of Sell</label>
                                    <select class="form-select" name="p_mos" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                        <option value="pieces" selected>Pieces</option>
                                        <option value="kg">K.g</option>
                                        <option value="liter">Liter</option>
                                    </select>
                                </div>
                                <input type="submit" name="btn_product_add" class="btn btn-primary" value="Add">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal End For Add Product -->


            <!-- Modal start For Edit Product -->
            <div class="modal fade" id="edit_product" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Edit Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="./command/product_sql.php" method="post">
                                <div class="mb-3">
                                    <label class="form-label">User Email</label>
                                    <input type="text" value="<?php echo $email; ?>" class="form-control" name="u_email" readonly style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Product ID</label>
                                    <input type="text" id="id" class="form-control" name="p_id" readonly style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Product Name</label>
                                    <input type="text" class="form-control" name="p_name" id="p_name" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Qty</label>
                                    <input type="text" class="form-control" name="p_qty" id="p_qty" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Mode of Sell</label>
                                    <select class="form-select" name="p_mos" id="p_type" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                        <option value="pieces" selected>Pieces</option>
                                        <option value="kg">K.g</option>
                                        <option value="liter">Liter</option>
                                    </select>
                                </div>
                                <input type="submit" name="btn_product_edit" class="btn btn-primary" value="Update Product">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal End For Edit Product -->


            <!-- Modal start For Delete Product -->
            <div class="modal fade" id="delete_product" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <form action="command/product_sql.php" method="post">
                            <div class="modal-body">
                                <input type="hidden" name="delete_p_id" id="d_id">
                                <h4>Are you sure? delete this product?</h4>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                <button type="submit" class="btn btn-danger" name="yes_btn" data-bs-dismiss="modal">Yes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal End For Delete Product -->


            <!-- Table Start -->
            <div class="table_data">
                <div class="container mt-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="table-responsive">
                                    <div class="card-header">
                                        <h4>Purchase
                                            <div class="float-end">
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                    Add Purchase
                                                </button>
                                            </div>
                                        </h4>
                                    </div>
                                    <div class="card-body">

                                        <table id="table_data_search" class="table table-bordered table-striped">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>ID</th>
                                                    <th>Product Name</th>
                                                    <th>Qty</th>
                                                    <th>Price</th>
                                                    <th>Type</th>
                                                    <th>Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center">
                                                    <td>10001</td>
                                                    <td>ABC</td>
                                                    <td>60</td>
                                                    <td>5000</td>
                                                    <td>Pics</td>
                                                    <td>10:52 PM</td>
                                                </tr>
                                                <tr class="text-center">
                                                    <td>10001</td>
                                                    <td>ABC</td>
                                                    <td>60</td>
                                                    <td>5000</td>
                                                    <td>Pics</td>
                                                    <td>10:52 PM</td>
                                                </tr>
                                                <tr class="text-center">
                                                    <td>10001</td>
                                                    <td>ABC</td>
                                                    <td>60</td>
                                                    <td>5000</td>
                                                    <td>Pics</td>
                                                    <td>10:52 PM</td>
                                                </tr>
                                                <tr class="text-center">
                                                    <td>10001</td>
                                                    <td>ABC</td>
                                                    <td>60</td>
                                                    <td>5000</td>
                                                    <td>Pics</td>
                                                    <td>10:52 PM</td>
                                                </tr>
                                                <tr class="text-center">
                                                    <td>10001</td>
                                                    <td>ABC</td>
                                                    <td>60</td>
                                                    <td>5000</td>
                                                    <td>Pics</td>
                                                    <td>10:52 PM</td>
                                                </tr>
                                                <tr class="text-center">
                                                    <td>10001</td>
                                                    <td>ABC</td>
                                                    <td>60</td>
                                                    <td>5000</td>
                                                    <td>Pics</td>
                                                    <td>10:52 PM</td>
                                                </tr>
                                                <?php
                                                // $query = "select id,product_name,qty,typeofsell from product where user_id='$u_id'";
                                                // $product_show_result = mysqli_query($con, $query);
                                                // while ($row = mysqli_fetch_row($product_show_result)) {
                                                //     echo "<tr>";
                                                //     echo "<td>" . $row[0] . "</td>";
                                                //     echo "<td>" . $row[1] . "</td>";
                                                //     echo "<td>" . $row[2] . "</td>";
                                                //     echo "<td>" . $row[3] . "</td>";
                                                //     echo "</tr>";
                                                // }
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
            </script>
            <!-- Main Content End -->
        </div>
    </div>
</div>

<?php include('footer.php'); ?>