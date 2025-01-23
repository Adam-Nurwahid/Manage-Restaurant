<?php 
include('other/header.php'); 
include('config/constants.php'); 

$sql = "SELECT * FROM tbl_food WHERE active='Yes'"; 
$res = mysqli_query($conn, $sql);

?>

<section class="food-search text-center">
    <div class="container">
        <form action="index.php" method="POST">
            <input type="search" name="search" placeholder="Search for Food.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>
    </div>
</section>

<?php
if (isset($_POST['submit'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
    echo "<section class='food-menu'><div class='container'>";
    echo "<h2 class='text-center'>Search Results for '$search'</h2>";

    $search_query = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%' AND active='Yes'";
    $search_result = mysqli_query($conn, $search_query);

    if (mysqli_num_rows($search_result) > 0) {
        while ($row = mysqli_fetch_assoc($search_result)) {
            ?>
            <div class="food-menu-box">
                <div class="food-menu-img">
                    <img src="images/<?php echo $row['image_name']; ?>" alt="<?php echo $row['title']; ?>" class="img-responsive img-curve">
                </div>
                <div class="food-menu-desc">
                    <h4><?php echo $row['title']; ?></h4>
                    <p class="food-price">$<?php echo $row['price']; ?></p>
                    <p class="food-detail"><?php echo $row['description']; ?></p>
                    <br>
                    <a href="order.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Order Now</a>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<p class='text-center'>No Food Found.</p>";
    }

    echo "</div></section>";
}
?>
<!-- fOOD sEARCH Section Ends Here -->

<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php 
        if(mysqli_num_rows($res) > 0) {
            // Menampilkan data makanan
            while($row = mysqli_fetch_assoc($res)) {
                ?>
                <div class="food-menu-box">
                    <div class="food-menu-img">
                        <img src="images/<?php echo $row['image_name']; ?>" alt="<?php echo $row['title']; ?>" class="img-responsive img-curve">
                    </div>

                    <div class="food-menu-desc">
                        <h4><?php echo $row['title']; ?></h4>
                        <p class="food-price">Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></p>
                        <p class="food-detail">
                            <?php echo $row['description']; ?>
                        </p>
                        <br>
                        <a href="order.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Order Now</a>
                    </div>
                </div>
                <div class="clearfix"></div>
                <?php
            }
        } else {
            echo "<p>No food items found.</p>";
        }
        ?>

    </div>
</section>
<!-- fOOD Menu Section Ends Here -->

<?php include('other/footer.php'); ?>
