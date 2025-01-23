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

    // Query untuk menghapus admin
    $sql = "DELETE FROM tbl_admin WHERE id=$id";

    $res = mysqli_query($conn, $sql);

    if ($res == TRUE) {
        echo "<script>alert('Admin deleted successfully!'); window.location.href='manage-admin.php';</script>";
    } else {
        echo "<script>alert('Failed to delete admin!'); window.location.href='manage-admin.php';</script>";
    }
} else {
    // Redirect jika tidak ada ID di URL
    header('location: manage-admin.php');
}
?>
