<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit;
}
?>


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

    // Query untuk menghapus kategori
    $sql = "DELETE FROM tbl_category WHERE id=$id";

    $res = mysqli_query($conn, $sql);

    if ($res == TRUE) {
        echo "<script>alert('Category deleted successfully!'); window.location.href='manage-category.php';</script>";
    } else {
        echo "<script>alert('Failed to delete category!'); window.location.href='manage-category.php';</script>";
    }
} else {
    // Redirect jika tidak ada ID di URL
    echo "<script>alert('No ID provided to delete!'); window.location.href='manage-category.php';</script>";
}
?>
