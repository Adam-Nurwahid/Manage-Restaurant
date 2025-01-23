<?php include('../partials/header.php'); ?>
<?php
session_start();


if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit;
}
?>


<?php
$conn = mysqli_connect('localhost', 'root', '', 'food-order');
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM tbl_food WHERE id=$id";
    $res = mysqli_query($conn, $sql);

    if ($res == TRUE && mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        $title = $row['title'];
        $description = $row['description'];
        $price = $row['price'];
        $image_name = $row['image_name'];
        $category_id = $row['category_id'];
        $featured = $row['featured'];
        $active = $row['active'];
    } else {
        header('location: manage-food.php');
    }
} else {
    header('location: manage-food.php');
}

if (isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $featured = mysqli_real_escape_string($conn, $_POST['featured']);
    $active = mysqli_real_escape_string($conn, $_POST['active']);
    $new_image_name = $image_name; // Default image jika tidak diubah

    if (isset($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];
        if ($image_name != "") {
            $temp = explode('.', $image_name); // Pisahkan nama file berdasarkan titik
            $ext = end($temp);
            $new_image_name = "Food_".rand(000, 999).'.'.$ext;
            $source_path = $_FILES['image']['tmp_name'];
            $destination_path = "../../images/foods/".$new_image_name;

            $upload = move_uploaded_file($source_path, $destination_path);
            if ($upload == false) {
                echo "<script>alert('Failed to upload image!');</script>";
                die();
            }

            // Hapus gambar lama jika ada
            if ($image_name != "" && file_exists("../../images/foods/" . $image_name)) {
                unlink("../../images/foods/" . $image_name);
            }
        }
    }

    $sql2 = "UPDATE tbl_food SET 
        title='$title', 
        description='$description', 
        price='$price', 
        image_name='$new_image_name', 
        category_id='$category_id', 
        featured='$featured', 
        active='$active' 
        WHERE id=$id";

    $res2 = mysqli_query($conn, $sql2);
    if ($res2 == TRUE) {
        echo "<script>alert('Food updated successfully!'); window.location.href='manage-food.php';</script>";
    } else {
        echo "<script>alert('Failed to update Food!');</script>";
    }
}
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" value="<?php echo $title; ?>" required></td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td><textarea name="description" required><?php echo $description; ?></textarea></td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td><input type="number" name="price" value="<?php echo $price; ?>" required></td>
                </tr>
                <tr>
                    <td>Category ID:</td>
                    <td><input type="number" name="category_id" value="<?php echo $category_id; ?>" required></td>
                </tr>
                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                        if ($image_name != "") {
                            echo "<img src='../../images/foods/$image_name' width='100px'>";
                        } else {
                            echo "No Image";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>New Image:</td>
                    <td><input type="file" name="image"></td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <select name="featured">
                            <option value="Yes" <?php if ($featured == "Yes") echo "selected"; ?>>Yes</option>
                            <option value="No" <?php if ($featured == "No") echo "selected"; ?>>No</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <select name="active">
                            <option value="Yes" <?php if ($active == "Yes") echo "selected"; ?>>Yes</option>
                            <option value="No" <?php if ($active == "No") echo "selected"; ?>>No</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('../partials/footer.php'); ?>
