<?php
require_once '../connection.php';
session_start();
$_SESSION['status'] = 'success';
$_SESSION['success'] = ['value' => '✅Payment Completed', 'timestamp' => time()];

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id'];

// ✅ Ensure $pid is fetched from GET or POST
if (!isset($_GET['pid'])) {
    die("Product ID not provided.");
}
$pid = $_GET['pid'];  // You may need to validate this properly

// First, fetch the product data
$psql = "SELECT * FROM product WHERE id = ?";
$stmt = mysqli_prepare($conn, $psql);
mysqli_stmt_bind_param($stmt, 'i', $pid);
mysqli_stmt_execute($stmt);
$pres = mysqli_stmt_get_result($stmt);

if (!$pres) {
    die("Product query failed: " . mysqli_error($conn));
}

$pdata = mysqli_fetch_assoc($pres);
if (!$pdata) {
    die("Product not found.");
}

$pname = $pdata['brand'];
$quantity = 1;
$price = $pdata['price'];
$tax = $price * 0.13;  // 13% VAT
$total = $price + $tax;
$cart_id = $pdata['ca_id'];  // Make sure this exists in your product table

// Insert order
$sql = "INSERT INTO orders (customer_id, product_id, product_name, total, quantity, cart_id) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'iisdii', $user_id, $pid, $pname, $total, $quantity, $cart_id);

$res = mysqli_stmt_execute($stmt);

if ($res) {
    echo "Ordered successfully.";
} else {
    die("Order insertion failed: " . mysqli_error($conn));
}
$update_purchase_count_sql = "
    UPDATE product p
    JOIN (
        SELECT product_id, COUNT(DISTINCT customer_id) AS unique_buyers
        FROM orders
        GROUP BY product_id
    ) AS summary ON p.id = summary.product_id
    SET p.purchase_count = summary.unique_buyers
";

if (!mysqli_query($conn, $update_purchase_count_sql)) {
    die("Failed to update purchase count: " . mysqli_error($conn));
}
// Clear the cart after order
$clear_cart_sql = "DELETE FROM cart WHERE customer_id = ?";
$clear_res = mysqli_prepare($conn, $clear_cart_sql);
mysqli_stmt_bind_param($clear_res, 'i', $user_id);
$clear_exec = mysqli_stmt_execute($clear_res);

if (!$clear_exec) {
    die("Failed to clear cart: " . mysqli_error($conn));
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status - Success</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="./css/checkout3.css">
    
</head>

<body>
    <div class="container">
        <div class="message-box _success">
            <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
            <h2> Your payment was successful </h2>
            <p> Thank you for your payment. <br> Redirecting to the homepage.</p>
        </div>
    </div>
    <script>
        setTimeout(() => {
            window.location.href = "customer_index.php";
        }, 5000);
    </script>
</body>

</html>