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
            <h1><i class="fas fa-user-plus"></i> Add Admin</h1>
            <br><br>

            <!-- Form untuk menambahkan admin -->
            <form action="" method="POST">
                <table class="tbl-30">
                    <tr>
                        <td><label for="full_name">Full Name:</label></td>
                        <td><input type="text" id="full_name" name="full_name" placeholder="Enter Your Name" required></td>
                    </tr>
                    <tr>
                        <td><label for="username">Username:</label></td>
                        <td><input type="text" id="username" name="username" placeholder="Your Username" required></td>
                    </tr>
                    <tr>
                        <td><label for="password">Password:</label></td>
                        <td><input type="password" id="password" name="password" placeholder="Your Password" required></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit" name="submit" class="btn-secondary">
                                <i class="fas fa-save"></i> Add Admin
                            </button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <?php
    // Cek apakah tombol "submit" telah diklik
    if (isset($_POST['submit'])) {
        // Ambil data dari form
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Enkripsi password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Koneksi ke database
        $conn = mysqli_connect('localhost', 'root', '', 'food-order'); // Sesuaikan dengan konfigurasi Anda

        // Periksa koneksi
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Query untuk menambahkan data admin
        $sql = "INSERT INTO tbl_admin (full_name, username, password) VALUES ('$full_name', '$username', '$hashed_password')";

        // Eksekusi query
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Admin berhasil ditambahkan');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        // Tutup koneksi
        mysqli_close($conn);
    }
    ?>
</body>

<?php include('../partials/footer.php'); ?>

</html>
