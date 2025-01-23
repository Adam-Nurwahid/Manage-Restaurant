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
    <h1>Manage Categories</h1>

    <br /><br />

    <!-- Button to Add Category -->
    <a href="add-category.php" class="btn-primary">Add Category</a>

    <br /><br /><br />

    <table class="tbl-full">
      <tr>
        <th>S.N.</th>
        <th>Title</th>
        <th>Image</th>
        <th>Featured</th>
        <th>Active</th>
        <th>Actions</th>
      </tr>

      <?php
      // Connect to database
      $conn = mysqli_connect('localhost', 'root', '', 'food-order');

      // Check if connection is successful
      if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
      }

      // Fetch all categories from the database
      $sql = "SELECT * FROM tbl_category";
      $res = mysqli_query($conn, $sql);

      // Check if there are categories in the database
      if ($res == TRUE) {
        $count = mysqli_num_rows($res); // Get the number of rows
        $sn = 1; // Create a variable to manage serial numbers

        // Check if data is available
        if ($count > 0) {
          while ($row = mysqli_fetch_assoc($res)) {
            $id = $row['id'];
            $title = $row['title'];
            $image_name = $row['image_name'];
            $featured = $row['featured'];
            $active = $row['active'];
      ?>

      <tr>
        <td><?php echo $sn++; ?>.</td>
        <td><?php echo $title; ?></td>
        <td>
          <?php
          // Check if image is available
          if ($image_name != "") {
            echo "<img src='../../images/category/$image_name' width='100px'>";
          } else {
            echo "No Image";
          }
          ?>
        </td>
        <td><?php echo $featured; ?></td>
        <td><?php echo $active; ?></td>
        <td>
  <a href="update-category.php?id=<?php echo $id; ?>" class="btn-secondary">
    <i class="fas fa-edit"></i></a>
  <a href="delete-category.php?id=<?php echo $id; ?>" class="btn-danger">
    <i class="fas fa-trash"></i></a>
</td>
      </tr>

      <?php
          }
        } else {
          // No categories in the database
          echo "<tr><td colspan='6' class='error'>No Categories Added Yet.</td></tr>";
        }
      }
      ?>

    </table>
  </div>
</div>

<?php include('../partials/footer.php'); ?>
