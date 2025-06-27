<?php
require_once '../connection.php';

// Count Queries
$csql = "SELECT * FROM customer";
$cresult = mysqli_query($conn, $csql);

$psql = "SELECT * FROM product";
$presult = mysqli_query($conn, $psql);

$osql = "SELECT * FROM orders";
$oresult = mysqli_query($conn, $osql);

$total_customer = mysqli_num_rows($cresult);
$total_product = mysqli_num_rows($presult);
$total_order = mysqli_num_rows($oresult);

// Chart Data Query for Today
$chart_sql = "SELECT DATE(order_date) AS day, 
                     SUM(total) AS revenue, 
                     SUM(quantity) AS total_quantity
              FROM orders
              WHERE DATE(order_date) >= CURDATE() - INTERVAL 7 DAY
              GROUP BY day
              ORDER BY day ASC";

$chart_result = mysqli_query($conn, $chart_sql);

// Check for SQL error
if (!$chart_result) {
    die("Chart SQL Error: " . mysqli_error($conn));
}

$labels = [];
$revenue = [];
$quantities = [];

while ($row = mysqli_fetch_assoc($chart_result)) {
    // Extract values from the row
    $labels[] = date("d M", strtotime($row['day']));  // e.g., 14 May
    $revenue[] = (float) $row['revenue'];  // Revenue as float
    $quantities[] = (int) $row['total_quantity'];  // Quantity as integer
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h2>Admin Dashboard</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="add_product.php">Add Products</a></li>
            <li><a href="user.php">Users</a></li>
            <li><a href="pending_orderr.php">Orders</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="manage_category.php">Manage Category</a></li>
             <li><a href="index.php">Logout</a></li>
        </ul>
    </div>

    <div class="main-content" id="main-content">
        <header>
            <button class="toggle-btn" id="toggle-btn">☰</button>
            <h1>Welcome, Admin</h1>
        </header>

        <section class="content">
            <div class="card">
                <img class="img" src="../images/user_icon.webp" alt="">
                <h3>Users</h3>
                <p>Number of Users: <?= $total_customer ?></p>
            </div>

            <div class="card">
                <img class="img" src="../images/shopping.webp" alt="">
                <h3>Products</h3>
                <p>Total Products: <?= $total_product ?></p>
            </div>

            <div class="card">
                <img class="img" src="../images/3d-order-online-shop-png.webp" alt="">
                <h3>Orders</h3>
                <p>Number of Orders: <?= $total_order ?></p>
            </div>
        </section>

        <!-- Chart Section -->
        <section class="chart-content" style="width: 90%; margin: auto;">
            <div class="card" style="width: 100%;">
                <h3 style="text-align: center;">Daily Revenue & Quantity Sold</h3>
                <canvas id="salesChart"></canvas>
            </div>
        </section>
    </div>

    <script>
        document.getElementById('toggle-btn').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('main-content').classList.toggle('active');
        });

        // Chart.js
        const ctx = document.getElementById('salesChart').getContext('2d');

        const salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($labels); ?>,  // ✅ Dates like "14 May"
                datasets: [
                    {
                        label: 'Revenue (Rs.)',
                        data: <?= json_encode($revenue); ?>,
                        backgroundColor: 'rgba(75, 192, 192, 0.7)',
                        yAxisID: 'y-axis-revenue',
                    },
                    {
                        label: 'Quantity Sold',
                        data: <?= json_encode($quantities); ?>,
                        backgroundColor: 'rgba(255, 159, 64, 0.7)',
                        yAxisID: 'y-axis-quantity',
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Daily Sales Overview (Last 7 Days)',
                        font: {
                            size: 16
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date',
                            font: {
                                size: 14
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                        }
                    },
                    'y-axis-revenue': {
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Revenue (Rs.)',
                            font: {
                                size: 14
                            }
                        }
                    },
                    'y-axis-quantity': {
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Quantity Sold',
                            font: {
                                size: 14
                            }
                        }
                    }
                }
            }
        });

    </script>
</body>

</html>