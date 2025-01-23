<?php 
include('other/header.php'); 
include('config/constants.php');
?>

<!-- Categories Section Starts Here -->
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
<!-- Categories Section Ends Here -->

<?php include('other/footer.php'); ?>
