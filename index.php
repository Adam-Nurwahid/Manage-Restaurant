<?php include('config/constants.php'); ?>
<?php include('other/header.php'); ?>

<!-- Food Search Section -->
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

<!-- Categories Section -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Foods</h2> 

        <?php
        // Query untuk mengambil data kategori dari tabel tbl_category
        $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
        $res = mysqli_query($conn, $sql);

        // Cek apakah ada data kategori yang ditemukan
        if($res == TRUE) {
            $count = mysqli_num_rows($res); // Menghitung jumlah baris
            if($count > 0) {
                // Looping untuk menampilkan setiap kategori
                while($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
                    ?>

<a href="category-food.php?category_id=<?php echo $id; ?>">
    <div class="box-3 float-container">
        <?php 
        if($image_name != "") {
            echo "<img src='images/category/".$image_name."' alt='".$title."' class='img-responsive img-curve'>";
        } else {
            echo "<div class='error'>Image not Available</div>";
        }
        ?>
        <h3 class="float-text text-white"><?php echo $title; ?></h3>
    </div>
</a>

                    <?php
                }
            } else {
                echo "<div class='error'>Category Not Found</div>";
            }
        }
        ?>

        <div class="clearfix"></div>
    </div>
</section>

<!-- Food Menu Section -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>
        <?php
        $food_query = "SELECT * FROM tbl_food WHERE active='Yes'";
        $food_result = mysqli_query($conn, $food_query);
        while ($row = mysqli_fetch_assoc($food_result)) {
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
        ?>
        <div class="clearfix"></div>
    </div>
</section>

<!-- Footer Section -->
<?php include('other/footer.php'); ?>
