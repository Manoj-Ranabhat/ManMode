<?php
session_start();
require('../connection.php'); 

if (!isset($_SESSION['user_id'])) {
    die("User is not logged in.");
}

if (isset($_POST['id'])) {
    $order_id = $_POST['id'];
    
    // Retrieve the dog_id from the order before deleting it
    $order_query = "SELECT product_id FROM orders WHERE id = $order_id";
    $order_result = mysqli_query($conn, $order_query);
    $order_data = mysqli_fetch_assoc($order_result);

    if ($order_data) {
        $product_id = $order_data['product_id'];
        
        // Delete the order
        $cancel_sql = "DELETE FROM orders WHERE id = $order_id";
        $cancel_res = mysqli_query($conn, $cancel_sql);

        if ($cancel_res) {
            // Restore the quantity of the pet
            $restore_sql = "UPDATE product SET quantity = quantity + 1 WHERE id = $product_id";
            $restore_res = mysqli_query($conn, $restore_sql);

            if ($restore_res) {
                echo "<script>alert('Order canceled and product quantity restored successfully.'); window.location.href='pending_orderr.php';</script>";
            } else {
                echo "<script>alert('Failed to restore the product quantity.'); window.location.href='pending_orderr.php';</script>";
            }
        } else {
            echo "<script>alert('Failed to cancel the order.'); window.location.href='pending_orderr.php';</script>";
        }
    } else {
        echo "<script>alert('Order not found.'); window.location.href='pending_orderr.php';</script>";
    }
} else {
    echo "<script>alert('Order ID is not set.'); window.location.href='pending_orderr.php';</script>";
}
?>
