<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food-order";

// Membuat koneksi
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Periksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Definisikan SITEURL untuk penggunaan pengalihan
define('SITEURL', 'http://localhost/nama_folder'); // Ganti 'nama_folder' dengan nama folder proyek Anda jika ada
?>
