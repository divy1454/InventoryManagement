<?php
include('command/conn.php');
session_start();
// unset($_SESSION['sales']);
if (!isset($_COOKIE['email']) && !isset($_COOKIE['pass'])) {
    header("Location: http://localhost/newproject/login/index.php");
    exit;
}


if (isset($_POST['pname']) && isset($_POST['cname']) && isset($_POST['qty']) && isset($_POST['price']) && isset($_POST['total'])) {
    $pname = $_POST['pname'];
    $cname = $_POST['cname'];
    $qty = $_POST['qty'];
    $price = $_POST['price'];
    $total = $_POST['total'];

    if (isset($_SESSION['sales'])) {
        $myiteam = array_column(($_SESSION['sales']), 'p_name');

        if (in_array($pname, $myiteam)) {
            echo "<script>alert('Product already added' );</script>";
        } else {
            $count = count($_SESSION['sales']);
            $_SESSION['sales'][$count] = array('p_name' => $pname, 'c_name' => $cname, 'qty' => $qty, 'price' => $price, 'total' => $total);

            foreach ($_SESSION['sales'] as $key => $value) {
?>
                <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $value['p_name']; ?></td>
                    <td><?php echo $value['qty']; ?></td>
                    <td><?php echo $value['price']; ?></td>
                    <td><?php echo $value['total']; ?></td>
                </tr>
            <?php
            }
        }
    } else {
        $_SESSION['sales'][0] = array('p_name' => $pname, 'c_name' => $cname, 'qty' => $qty, 'price' => $price, 'total' => $total);
        foreach ($_SESSION['sales'] as $key => $value) {
            ?>
            <tr>
                <td><?php echo ""; ?></td>
                <td><?php echo $value['p_name']; ?></td>
                <td><?php echo $value['qty']; ?></td>
                <td><?php echo $value['price']; ?></td>
                <td><?php echo $value['total']; ?></td>
            </tr>
<?php
        }
    }
}
