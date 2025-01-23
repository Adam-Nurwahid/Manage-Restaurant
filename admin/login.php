<?php
session_start();
include('../config/constants.php'); // File untuk koneksi ke database

// Proses login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi input
    if (empty($username) || empty($password)) {
        $error = "Username dan password tidak boleh kosong.";
    } else {
        // Query untuk mendapatkan data admin berdasarkan username
        $stmt = $conn->prepare("SELECT * FROM tbl_admin WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                // Simpan informasi login ke session
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username'] = $user['username'];
                $_SESSION['admin_full_name'] = $user['full_name'];
                $_SESSION['admin_id'] = $user['id'];

                // Simpan admin ID ke variabel global MySQL
                $admin_id = $user['id'];
                $conn->query("SET @current_admin_id = $admin_id");

                // Redirect ke halaman admin
                header("Location: home/index.php");
                exit;
            } else {
                $error = "Password salah.";
            }
        } else {
            $error = "Username tidak ditemukan.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../css/login.css"> <!-- Pastikan file CSS ini ada -->
</head>
<body>
    <div class="card">
        <div class="login-card">
            <h1>Login</h1>
        </div>
        <form method="POST" action="login.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <button type="submit">Login</button>
        </form>

        <!-- Menampilkan pesan error jika ada -->
        <?php if (isset($error)) { ?>
            <p style="color: red; text-align: center;"><?php echo $error; ?></p>
        <?php } ?>
    </div>
</body>
</html>
