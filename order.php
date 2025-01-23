<?php
include('other/header.php');
include('config/constants.php');

// Cek apakah ID makanan dikirim melalui URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data makanan berdasarkan ID
    $food_query = "SELECT * FROM tbl_food WHERE id=$id AND active='Yes'";
    $food_result = mysqli_query($conn, $food_query);

    if (mysqli_num_rows($food_result) == 1) {
        $row = mysqli_fetch_assoc($food_result);
        $title = $row['title'];
        $price = $row['price'];
        $image_name = $row['image_name'];
    } else {
        // Redirect jika makanan tidak ditemukan
        header('location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
} else {
    // Redirect jika ID makanan tidak ditemukan di URL
    header('location: ' . $_SERVER['PHP_SELF']);
    exit();
}
?>

<section class="food-search">
    <div class="container">
        <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

        <form action="" method="POST" class="order">
            <fieldset>
                <legend>Selected Food</legend>

                <div class="food-menu-img">
                    <?php if ($image_name != "") { ?>
                        <img src="images/foods/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                    <?php } else { ?>
                        <p class="error">Image not available.</p>
                    <?php } ?>
                </div>

                <div class="food-menu-desc">
                    <h3><?php echo $title; ?></h3>
                    <p class="food-price">$<?php echo $price; ?></p>

                    <div class="order-label">Quantity</div>
                    <input type="number" name="qty" class="input-responsive" value="1" required>
                </div>
            </fieldset>

            <fieldset>
                <legend>Delivery Details</legend>

                <div class="order-label">Full Name</div>
                <input type="text" name="customer_name" placeholder="Enter your full name" class="input-responsive" required>

                <div class="order-label">Phone Number</div>
                <input type="tel" name="customer_contact" placeholder="Enter your phone number" class="input-responsive" required>

                <div class="order-label">Email</div>
                <input type="email" name="customer_email" placeholder="Enter your email" class="input-responsive" required>

                <div class="order-label">Address</div>
                <textarea name="customer_address" rows="10" placeholder="Enter your delivery address" class="input-responsive" required></textarea>

                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
            </fieldset>
        </form>
    </div>
</section>

<?php
if (isset($_POST['submit'])) {
    // Ambil data dari form
    $qty = $_POST['qty'];
    $total = $price * $qty;
    $order_date = date("Y-m-d H:i:s"); // Waktu pemesanan
    $status = "Ordered"; // Status awal

    $customer_name = $_POST['customer_name'];
    $customer_contact = $_POST['customer_contact'];
    $customer_email = $_POST['customer_email'];
    $customer_address = $_POST['customer_address'];

    // Simpan data ke database
    $order_query = "INSERT INTO tbl_order SET
        food = '$title',
        price = $price,
        qty = $qty,
        total = $total,
        order_date = '$order_date',
        status = '$status',
        customer_name = '$customer_name',
        customer_contact = '$customer_contact',
        customer_email = '$customer_email',
        customer_address = '$customer_address'";

    $order_result = mysqli_query($conn, $order_query);

    if ($order_result) {
        // Set session untuk pesan sukses
        $_SESSION['order'] = "Food Ordered Successfully!";
        echo "<script>alert('Food Ordered Successfully!');</script>";
    } else {
        // Set session untuk pesan gagal
        $_SESSION['order'] = "Failed to Order Food.";
        echo "<script>alert('Failed to Order Food.');</script>";
    }
}
?>

<?php
include('other/footer.php');
?>
