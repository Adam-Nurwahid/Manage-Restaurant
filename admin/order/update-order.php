<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food-order";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data order berdasarkan ID
    $sql = "SELECT * FROM tbl_order WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Order not found.";
    }

    if (isset($_POST['update'])) {
        $food = $_POST['food'];
        $price = $_POST['price'];
        $qty = $_POST['qty'];
        $order_date = $_POST['order_date'];
        $status = $_POST['status'];  // Status baru
        $customer_name = $_POST['customer_name'];
        $customer_contact = $_POST['customer_contact'];
        $customer_email = $_POST['customer_email'];
        $customer_address = $_POST['customer_address'];
    
        // Update data ke database
        $update_sql = "UPDATE tbl_order SET food = '$food', price = '$price', qty = '$qty', order_date = '$order_date', 
        status = '$status', customer_name = '$customer_name', customer_contact = '$customer_contact', 
        customer_email = '$customer_email', customer_address = '$customer_address' WHERE id = $id";

    
        if ($conn->query($update_sql) === TRUE) {
            echo "Order updated successfully.";
        } else {
            echo "Error: " . $conn->error;
        }
    }
    
} else {
    echo "No order ID provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 14px;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        input[type="email"],
        input[type="submit"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group input {
            width: 100%;
            box-sizing: border-box;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .back-button {
            background-color: #2196F3;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .back-button:hover {
            background-color: #0b7dda;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Update Order</h1>

        <form method="POST">
            <div class="form-group">
                <label for="food">Food:</label>
                <input type="text" id="food" name="food" value="<?php echo $row['food']; ?>" required>
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" value="<?php echo $row['price']; ?>" required>
            </div>

            <div class="form-group">
                <label for="qty">Quantity:</label>
                <input type="number" id="qty" name="qty" value="<?php echo $row['qty']; ?>" required>
            </div>

            <div class="form-group">
                <label for="order_date">Order Date:</label>
                <input type="date" id="order_date" name="order_date" value="<?php echo $row['order_date']; ?>" required>
            </div>

            <div class="form-group">
    <label for="status">Status:</label>
    <select id="status" name="status" required>
        <option value="Ordered" <?php echo $row['status'] == 'Ordered' ? 'selected' : ''; ?>>Ordered</option>
        <option value="Done" <?php echo $row['status'] == 'Done' ? 'selected' : ''; ?>>Done</option>
        <option value="Cancel" <?php echo $row['status'] == 'Cancel' ? 'selected' : ''; ?>>Cancel</option>
    </select>
</div>


            <div class="form-group">
                <label for="customer_name">Customer Name:</label>
                <input type="text" id="customer_name" name="customer_name" value="<?php echo $row['customer_name']; ?>" required>
            </div>

            <div class="form-group">
                <label for="customer_contact">Contact:</label>
                <input type="text" id="customer_contact" name="customer_contact" value="<?php echo $row['customer_contact']; ?>" required>
            </div>

            <div class="form-group">
                <label for="customer_email">Email:</label>
                <input type="email" id="customer_email" name="customer_email" value="<?php echo $row['customer_email']; ?>" required>
            </div>

            <div class="form-group">
                <label for="customer_address">Address:</label>
                <input type="text" id="customer_address" name="customer_address" value="<?php echo $row['customer_address']; ?>" required>
            </div>

            <div class="form-group">
                <input type="submit" name="update" value="Update Order">
            </div>
        </form>

        <div class="button-container">
            <a href="manage-order.php" class="back-button">Back to Manage Food</a>
        </div>
    </div>

</body>
</html>

<?php
// Menutup koneksi
$conn->close();
?>
