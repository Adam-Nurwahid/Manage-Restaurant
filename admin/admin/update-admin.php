<?php
session_start();


if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit;
}
?>


<?php include('../partials/header.php'); ?>
  
  
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

// Periksa apakah ID tersedia di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mendapatkan data admin berdasarkan ID
    $sql = "SELECT * FROM tbl_admin WHERE id=$id";
    $res = mysqli_query($conn, $sql);

    if ($res == TRUE && mysqli_num_rows($res) == 1) {
        // Ambil data admin
        $row = mysqli_fetch_assoc($res);
        $full_name = $row['full_name'];
        $username = $row['username'];
    } else {
        // Redirect jika ID tidak valid
        header('location: manage-admin.php');
    }
} else {
    // Redirect jika tidak ada ID di URL
    header('location: manage-admin.php');
}

// Update data admin jika form disubmit
if (isset($_POST['submit'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);

    $sql2 = "UPDATE tbl_admin SET full_name='$full_name', username='$username' WHERE id=$id";

    $res2 = mysqli_query($conn, $sql2);

    if ($res2 == TRUE) {
        echo "<script>alert('Admin updated successfully!'); window.location.href='manage-admin.php';</script>";
    } else {
        echo "<script>alert('Failed to update admin!');</script>";
    }
}
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br><br>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td><input type="text" name="full_name" value="<?php echo $full_name; ?>" required></td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" value="<?php echo $username; ?>" required></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>
