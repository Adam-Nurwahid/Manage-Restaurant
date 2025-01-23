<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit;
}
?>


<?php include('../partials/header.php'); ?>

<?php
$conn = mysqli_connect('localhost', 'root', '', 'food-order');
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM tbl_category WHERE id=$id";
    $res = mysqli_query($conn, $sql);

    if ($res == TRUE && mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        $title = $row['title'];
        $image_name = $row['image_name'];
        $featured = $row['featured'];
        $active = $row['active'];
    } else {
        header('location: manage-category.php');
    }
} else {
    header('location: manage-category.php');
}

if (isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $featured = mysqli_real_escape_string($conn, $_POST['featured']);
    $active = mysqli_real_escape_string($conn, $_POST['active']);

    if (isset($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];
        if ($image_name != "") {
            $temp = explode('.', $image_name); // Pisahkan nama file berdasarkan titik
            $ext = end($temp);
            $image_name = "Category_".rand(000, 999).'.'.$ext;
            $source_path = $_FILES['image']['tmp_name'];
            $destination_path = "../../images/category/".$image_name;

            $upload = move_uploaded_file($source_path, $destination_path);
            if ($upload == false) {
                echo "<script>alert('Failed to upload image!');</script>";
                die();
            }
        }
    }

    $sql2 = "UPDATE tbl_category SET 
        title='$title', 
        image_name='$image_name', 
        featured='$featured', 
        active='$active' 
        WHERE id=$id";

    $res2 = mysqli_query($conn, $sql2);
    if ($res2 == TRUE) {
        echo "<script>alert('Category updated successfully!'); window.location.href='manage-category.php';</script>";
    } else {
        echo "<script>alert('Failed to update category!');</script>";
    }
}
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" value="<?php echo $title; ?>" required></td>
                </tr>
                <tr>
                    <td>Image:</td>
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
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('../partials/footer.php'); ?>
