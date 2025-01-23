<?php
session_start();


if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit;
}
?>



<?php include('../partials/header.php'); ?>
<div class="main-content">
  <div class="wrapper">
    <h1>Add Category</h1>
    <br><br>

    <?php
    if (isset($_SESSION['add'])) {
        echo $_SESSION['add'];
        unset($_SESSION['add']);
    }
    ?>
    <br><br>

    <form action="" method="POST" enctype="multipart/form-data">
      <table class="tbl-30">
        <tr>
          <td>Title:</td>
          <td><input type="text" name="title" placeholder="Enter Category Title" required></td>
        </tr>
        <tr>
          <td>Featured:</td>
          <td>
            <select name="featured">
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </td>
        </tr>
        <tr>
          <td>Active:</td>
          <td>
            <select name="active">
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </td>
        </tr>
        <tr>
          <td>Upload Image:</td>
          <td><input type="file" name="image"></td>
        </tr>
        <tr>
          <td colspan="2">
            <input type="submit" name="submit" value="Add Category" class="btn-primary">
          </td>
        </tr>
      </table>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        include('../../config/constants.php'); // Pastikan path benar

        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $featured = mysqli_real_escape_string($conn, $_POST['featured']);
        $active = mysqli_real_escape_string($conn, $_POST['active']);

        $image_name = ""; // Default jika tidak ada gambar
        if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
            $image_name = $_FILES['image']['name'];
            $ext = pathinfo($image_name, PATHINFO_EXTENSION);
            $image_name = "Category_" . rand(1000, 9999) . '.' . $ext;
            $source_path = $_FILES['image']['tmp_name'];
            $destination_path = "../../images/category/" . $image_name;
            $upload = move_uploaded_file($source_path, $destination_path);
            if ($upload == false) {
                die("Failed to upload image.");
            }
        }

        $sql = "INSERT INTO tbl_category (title, image_name, featured, active) 
                VALUES ('$title', '$image_name', '$featured', '$active')";

        $res = mysqli_query($conn, $sql);

        if ($res == true) {
            echo "<div class='success'>Category Added Successfully.</div>";
        } else {
            echo "Query Error: " . mysqli_error($conn);
        }
    }
    ?>
  </div>
</div>
<?php include('../partials/footer.php'); ?>
