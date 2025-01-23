<?php include('../partials/header.php'); ?>
<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit;
}
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Order</h1>
        <br><br><br>
        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Food</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Address</th>
                <th>Action</th>
            </tr>

            <?php
            $conn = mysqli_connect('localhost', 'root', '', 'food-order');

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Fetch all orders from the database
            $sql = "SELECT * FROM tbl_order ORDER BY order_date DESC";
            $res = mysqli_query($conn, $sql);

            if ($res == true) {
                $count = mysqli_num_rows($res);
                $sn = 1; // Serial number counter

                if ($count > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
                        $food = $row['food'];
                        $price = $row['price'];
                        $qty = $row['qty'];
                        $total = $row['total'];
                        $order_date = $row['order_date'];
                        $status = $row['status'];
                        $customer_name = $row['customer_name'];
                        $customer_contact = $row['customer_contact'];
                        $customer_email = $row['customer_email'];
                        $customer_address = $row['customer_address'];
                        ?>

                        <tr>
                            <td><?php echo $sn++; ?>.</td>
                            <td><?php echo $food; ?></td>
                            <td><?php echo $price; ?></td>
                            <td><?php echo $qty; ?></td>
                            <td><?php echo $total; ?></td>
                            <td><?php echo $order_date; ?></td>
                            <td>
    <?php
    
    echo $status; 

    ?>
</td>

                            <td><?php echo $customer_name; ?></td>
                            <td><?php echo $customer_contact; ?></td>
                            <td><?php echo $customer_email; ?></td>
                            <td><?php echo $customer_address; ?></td>
                            <td>
                                <a href="update-order.php?id=<?php echo $id; ?>" class="btn-secondary"><i class="fas fa-edit"></i></a>
                                <a href="delete-order.php?id=<?php echo $id; ?>" class="btn-danger"><i class="fas fa-trash"></i></a>
                                <a href="invoice.php?id=<?php echo $id; ?>" class="btn-primary"><i class="fas fa-file-invoice"></i> Print Invoice</a>
                            </td>
                        </tr>

                        <?php
                    }
                } else {
                    // No orders in the database
                    echo "<tr><td colspan='12' class='error'>No Orders Available.</td></tr>";
                }
            }
            ?>
        </table>
    </div>
</div>
<?php include('../partials/footer.php'); ?>