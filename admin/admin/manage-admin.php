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
    <h1>Manage Admin</h1>

    <a href="add-admin.php" class="btn-primary">+ Add Admin</a>

    <table class="tbl-full">
      <tr>
        <th>S.N.</th>
        <th>Full Name</th>
        <th>Username</th>
        <th>Actions</th>
      </tr>

      <?php
      // Koneksi ke database
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "food-order";

      $conn = mysqli_connect($servername, $username, $password, $dbname);

      if (!$conn) {
          die("Koneksi gagal: " . mysqli_connect_error());
      }

      // Query untuk mengambil data admin
      $sql = "SELECT * FROM tbl_admin";
      $res = mysqli_query($conn, $sql);

      if ($res == TRUE) {
          $sn = 1; // Variabel untuk nomor urut
          $count = mysqli_num_rows($res);

          if ($count > 0) {
              while ($row = mysqli_fetch_assoc($res)) {
                  $id = $row['id'];
                  $full_name = $row['full_name'];
                  $username = $row['username'];

                  echo "<tr>
                          <td>$sn</td>
                          <td>$full_name</td>
                          <td>$username</td>
                          <td>
  <a href='update-admin.php?id=$id' class='btn-secondary'>
    <i class='fas fa-edit'></i>
  </a>
  <a href='delete-admin.php?id=$id' class='btn-danger'>
    <i class='fas fa-trash'></i>
  </a>
</td>
                        </tr>";
                  $sn++;
              }
          } else {
              echo "<tr><td colspan='4' class='error'>No Admins Found</td></tr>";
          }
      } else {
          echo "<tr><td colspan='4' class='error'>Failed to Fetch Admin Data</td></tr>";
      }
      ?>
    </table>
  </div>
</div>

<?php
// Include footer.php dari folder partials
include('../partials/footer.php');
?>
