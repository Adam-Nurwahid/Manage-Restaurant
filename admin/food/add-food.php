<?php
session_start();



if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit;
}
?>

<?php

$conn = mysqli_connect('localhost', 'root', '', 'food-order');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = "";

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $featured = $_POST['featured'];
    $active = $_POST['active'];

    if (isset($_FILES['image_name']['name']) && $_FILES['image_name']['name'] != "") {
        $image_name = $_FILES['image_name']['name'];

        $target_directory = "../../images/foods/";
        $target_file = $target_directory . basename($image_name);
        move_uploaded_file($_FILES['image_name']['tmp_name'], $target_file);
    } else {
        $image_name = ""; 
    }

    $sql = "INSERT INTO tbl_food (title, description, price, image_name, category_id, featured, active)
            VALUES ('$title', '$description', $price, '$image_name', $category_id, '$featured', '$active')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $message = "Food added successfully!";
    } else {
        $message = "Failed to add food: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Food</title>
    <link rel="stylesheet" href="../../css/add-food.css">
    <link rel="stylesheet" href="../../css/admin.css">
    <style>
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            border: 1px solid #ccc;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        .popup .message {
            margin-bottom: 20px;
        }
        .popup .close-btn {
            background: #ff5e57;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="wrapper">
            <h1><i class="fa fa-plus"></i> Add Food</h1>
            <form action="" method="POST" enctype="multipart/form-data" class="form-container">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" name="title" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea name="description" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" name="price" required>
                </div>
                <div class="form-group">
                    <label for="category_id">Category:</label>
                    <select name="category_id" required>
                        <?php
                        $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['id'] . "'>" . $row['title'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No categories available</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="image_name">Image:</label>
                    <input type="file" name="image_name">
                </div>
                <div class="form-group">
                    <label for="featured">Featured:</label>
                    <select name="featured" required>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="active">Active:</label>
                    <select name="active" required>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <button type="submit" name="submit" class="btn-primary">Add Food</button>
                <a href="manage-food.php" class="btn-secondary">Back to Manage Food</a>
            </form>
        </div>
    </div>

    <div class="popup" id="popup">
        <div class="message"><?php echo $message; ?></div>
        <button class="close-btn" onclick="closePopup()">Close</button>
    </div>

    <script>
        function closePopup() {
            document.getElementById('popup').style.display = 'none';
        }

        <?php if ($message != "") { ?>
            document.getElementById('popup').style.display = 'block';
        <?php } ?>
    </script>

<?php include('../partials/footer.php'); ?>

</body>
</html>
