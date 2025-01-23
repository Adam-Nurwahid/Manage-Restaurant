<?php


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food-order";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data dari tabel tbl_order
$sql = "SELECT DATE(order_date) as order_date, SUM(price * qty) as total_sales FROM tbl_order GROUP BY DATE(order_date)";
$result = $conn->query($sql);

$data = [
    "labels" => [],
    "values" => []
];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data['labels'][] = $row['order_date']; // Tanggal order
        $data['values'][] = $row['total_sales']; // Total penjualan
    }
} else {
    // Tambahkan log untuk mempermudah debugging
    if (!$result) {
        error_log("Query error: " . $conn->error);
    } else {
        error_log("No data found in tbl_order.");
    }
}

// Kirim data sebagai JSON
header('Content-Type: application/json');
echo json_encode($data);

// Menutup koneksi
$conn->close();
?>
