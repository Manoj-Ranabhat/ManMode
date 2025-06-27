<?php
session_start();
require_once "../connection.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: customer_login.php"); // Redirect to login page if not logged in
    exit;
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

// Fetch only the orders of the logged-in user
$sql = "SELECT o.order_id, o.customer_id, o.product_id, o.product_name, o.quantity, o.total, c.name 
        FROM orders o
        JOIN customer c ON o.customer_id = c.id
        WHERE o.customer_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <style>
        /* Body Styling */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
        }

        /* Container Styling */
        .container {
            width: 90%;
            margin: auto;
            padding: 20px;
            background-color: #f9f9f9;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: auto;
        }

        /* General Table Styling */
        table {
            width: 80%;
            border-collapse: collapse;
            margin: auto;
            font-size: 1em;
            font-family: 'Arial', sans-serif;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 150px;
        }

        /* Table Head Styling */
        thead tr {
            background-color: #817474;
            color: #ffffff;
            text-align: left;
            font-weight: bold;
        }

        thead th {
            font-weight: bold;
            font-size: 1.1em;
            text-transform: uppercase;
        }

        /* Table Body Styling */
        th, td {
            padding: 12px 10px;
            border: 1px solid #dee2e6;
            text-align: center;
        }

        tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Back Button */
        .btn-back {
            display: inline-block;
            background-color: black;
            color: white;
            padding: 10px 15px;
            border-radius: 6px;
            text-decoration: none;
            margin: 20px;
        }

        .btn-back:hover {
            background-color: #242425;
        }
    </style>
</head>
<body>
<?php include_once('../includes/header.php'); ?>
    

    <h1 style="text-align: center;">My Orders</h1>

    <table>
        <thead>
            <tr>
                <!-- <th>Order ID</th> -->
                <th>Customer Name</th>
                <!-- <th>Product ID</th> -->
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Total (Rs)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    // echo "<td>" . htmlspecialchars($row['order_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    // echo "<td>" . htmlspecialchars($row['product_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                    echo "<td>Rs. " . number_format($row['total'], 2) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No orders found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <?php include_once('../includes/footer.php'); ?>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
