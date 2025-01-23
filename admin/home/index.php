<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
    <?php
    // Include header.php dari folder partials
    include('../partials/header.php');
    ?>

    <div class="container">
        <h1>Admin Dashboard</h1>
        <canvas id="salesChart" width="400" height="200"></canvas>
        <a href="../logout.php" style="display: inline-block; background-color: #e74c3c; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-size: 16px; margin-top: 20px;">Logout</a>
    </div>

    <?php
    // Include footer.php dari folder partials
    include('../partials/footer.php');
    ?>

    <script>
        // Fetch data from PHP
        fetch('fetch-data.php') // Pastikan path sudah benar
            .then(response => {
                if (!response.ok) {
                    throw new Error("HTTP error " + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (data.labels.length === 0 || data.values.length === 0) {
                    console.error("No data available to display.");
                    return;
                }
                const ctx = document.getElementById('salesChart').getContext('2d');
                const chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels, // Dates
                        datasets: [{
                            label: 'Total Sales',
                            data: data.values, // Sales totals
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Date'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Total Sales'
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => {
                console.error("Error fetching data:", error);
            });
    </script>
</body>
</html>
