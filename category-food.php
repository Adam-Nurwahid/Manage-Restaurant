<?php
include('other/header.php'); 
include('config/constants.php');

// Get the category_id from the URL
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    // Query to get the category title
    $sql_category = "SELECT title FROM tbl_category WHERE id = $category_id";
    $res_category = mysqli_query($conn, $sql_category);

    if ($res_category && mysqli_num_rows($res_category) > 0) {
        $row_category = mysqli_fetch_assoc($res_category);
        $category_title = $row_category['title'];
    } else {
        // Redirect if category not found
        header("Location: index.php");
        exit;
    }
} else {
    // Redirect if no category_id is set
    header("Location: category.php");
    exit;
}
?>
  <body>
      <!-- Food Search Section -->
    <section class="food-search text-center">
      <div class="container">
        <h2>Foods in <a href="#" class="text-white">"<?php echo $category_title; ?>"</a></h2>
      </div>
    </section>

    <!-- Food Menu Section -->
    <section class="food-menu">
      <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php
        // Query to get foods based on category
        $sql_food = "SELECT * FROM tbl_food WHERE category_id = $category_id AND active = 'Yes'";
        $res_food = mysqli_query($conn, $sql_food);

        if ($res_food && mysqli_num_rows($res_food) > 0) {
            while ($row_food = mysqli_fetch_assoc($res_food)) {
                $title = $row_food['title'];
                $price = $row_food['price'];
                $description = $row_food['description'];
                $image_name = $row_food['image_name'];
                ?>
                <div class="food-menu-box">
                  <div class="food-menu-img">
                    <?php if ($image_name != "") { ?>
                      <img src="images/foods/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve" />
                    <?php } else { ?>
                      <img src="images/default-food.jpg" alt="No Image" class="img-responsive img-curve" />
                    <?php } ?>
                  </div>

                  <div class="food-menu-desc">
                    <h4><?php echo $title; ?></h4>
                    <p class="food-price">Rp <?php echo $price; ?></p>
                    <p class="food-detail"><?php echo $description; ?></p>
                    <br />
                    <a href="order.php?id=<?php echo $row_food['id']; ?>" class="btn btn-primary">Order Now</a>

                  </div>
                </div>
                <?php
            }
        } else {
            echo "<div class='error'>No Foods Available in this Category.</div>";
        }
        ?>

        <div class="clearfix"></div>
      </div>
      </section>
    <!-- Footer Section -->
    <?php include('other/footer.php'); ?>
  </body>
</html>
