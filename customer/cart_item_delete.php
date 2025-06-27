<?php
session_start();
require_once '../connection.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['invalid'] = ['value' => '❗Please login First', 'timestamp' => time()];
    header('Location: customer_login.php');
    exit;
}

$customer_id = $_SESSION['user_id'];

if (isset($_GET['cid'])) {
    $cart_id = $_GET['cid'];

    // Delete the item from the cart in the database
    $deleteSql = "DELETE FROM cart WHERE cart_id = $cart_id AND customer_id = $customer_id";
    $result = mysqli_query($conn, $deleteSql);

    if ($result) {
        // Get the product ID to remove from the session cart
        $productSql = "SELECT product_id FROM cart WHERE cart_id = $cart_id AND customer_id = $customer_id";
        $productResult = mysqli_query($conn, $productSql);
        if ($productResult && mysqli_num_rows($productResult) > 0) {
            $productRow = mysqli_fetch_assoc($productResult);
            $productId = $productRow['product_id'];

            // Remove from session cart
            if (isset($_SESSION['cart'][$productId])) {
                unset($_SESSION['cart'][$productId]);
            }
        }

        // Redirect to the cart page with a success message
        $_SESSION['success'] = 'Product removed from cart successfully.';
        header('Location: customer_view_cart.php');
        exit;
    } else {
        $_SESSION['error'] = 'Failed to remove product from cart.';
        header('Location: customer_view_cart.php');
        exit;
    }
}
?>
