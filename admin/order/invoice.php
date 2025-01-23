<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$database = "food-order";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data order berdasarkan ID (misalnya ID diberikan melalui URL)
$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql = "SELECT * FROM tbl_order WHERE id = $order_id";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $order = $result->fetch_assoc();
} else {
    die("Pesanan tidak ditemukan.");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f9f9f9;
        }
        .invoice {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .invoice-header p {
            margin: 0;
            color: #666;
        }
        .invoice-details {
            margin-bottom: 20px;
        }
        .invoice-details h3 {
            margin-bottom: 10px;
        }
        .invoice-details p {
            margin: 5px 0;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .invoice-table th, .invoice-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .invoice-table th {
            background-color: #f4f4f4;
        }
        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="invoice">
        <div class="invoice-header">
            <h1>Invoice</h1>
            <p>Order ID: <?php echo $order['id']; ?></p>
        </div>

        <div class="invoice-details">
            <h3>Customer Details</h3>
            <p><strong>Name:</strong> <?php echo $order['customer_name']; ?></p>
            <p><strong>Email:</strong> <?php echo $order['customer_email']; ?></p>
            <p><strong>Contact:</strong> <?php echo $order['customer_contact']; ?></p>
            <p><strong>Address:</strong> <?php echo $order['customer_address']; ?></p>
        </div>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Food</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $order['food']; ?></td>
                    <td><?php echo number_format($order['price'], 2); ?></td>
                    <td><?php echo $order['qty']; ?></td>
                    <td><?php echo number_format($order['total'], 2); ?></td>
                </tr>
            </tbody>
        </table>

        <p class="total">Grand Total: <?php echo number_format($order['total'], 2); ?></p>

        <p><strong>Order Date:</strong> <?php echo $order['order_date']; ?></p>
        <p><strong>Status:</strong> <?php echo ucfirst($order['status']); ?></p>
    </div>
</body>
</html>
