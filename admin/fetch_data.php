<?php
session_start();
include('../partials/db_connect.php'); // Koneksi ke database

// Pastikan admin sudah login
if (!isset($_SESSION['admin_id'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Ambil admin_id dari session
$admin_id = $_SESSION['admin_id'];

// Query data milik admin yang sedang login
$query = "SELECT date, total_sales FROM tbl_sales WHERE admin_id = ? ORDER BY date ASC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();

// Array untuk menyimpan data
$data = array();
$labels = array();
$values = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $labels[] = $row['date'];
        $values[] = $row['total_sales'];
    }
}

// Mengembalikan data dalam format JSON
echo json_encode([
    'labels' => $labels,
    'values' => $values
]);
?>
