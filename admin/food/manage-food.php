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
        <h1>Manage Food</h1>
        <br><br>
        <a href="add-food.php" class="btn-primary">Add Food</a>
        <br><br><br>
        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Category ID</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Action</th>
            </tr>

            <?php
          
            $conn = mysqli_connect('localhost', 'root', '', 'food-order');

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Fetch all categories from the database
            $sql = "SELECT * FROM tbl_food";
            $res = mysqli_query($conn, $sql);

            // Check if there are categories in the database
            if ($res == true) {
                $count = mysqli_num_rows($res); // Get the number of rows
                $sn = 1; // Create a variable to manage serial numbers

                // Check if data is available
                if ($count > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
                        $title = $row['title'];
                        $description = $row['description'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        $category_id = $row['category_id'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                        ?>

                        <tr>
                            <td><?php echo $sn++; ?>.</td>
                            <td><?php echo $title; ?></td>
                            <td><?php echo $description; ?></td>
                            <td><?php echo $price; ?></td>
                            <td>
                                <?php
                                // Check if image is available
                                if ($image_name != "") {
                                    echo "<img src='../../images/foods/$image_name' width='100px'>";
                                } else {
                                    echo "No Image";
                                }
                                ?>
                            </td>
                            <td><?php echo $category_id; ?></td>
                            <td><?php echo $featured; ?></td>
                            <td><?php echo $active; ?></td>
                            <td>
                                <a href="update-food.php?id=<?php echo $id; ?>" class="btn-secondary"><i class="fas fa-edit"></i></a>
                                <a href="delete-food.php?id=<?php echo $id; ?>" class="btn-danger"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>

                        <?php
                    }
                } else {
                    // No categories in the database
                    echo "<tr><td colspan='8' class='error'>No Food Added Yet.</td></tr>";
                }
            }
            ?>

        </table>
    </div>
</div>
<?php
// Include footer.php dari folder partials
include('../partials/footer.php');
?>