<?php
require_once '../connection.php';
session_start();

header('Content-Type: application/json');

if (!empty($_POST)) {
    $productId = (int)$_POST['product_id'];
    $customer_id = (int)$_POST['customer_id'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    if ($quantity <= 0) {
        echo json_encode(['status' => 'fail', 'msg' => 'Invalid quantity']);
        exit;
    }

    // Get product details including available stock
    $productSql = "SELECT * FROM product WHERE id = $productId";
    $productResult = mysqli_query($conn, $productSql);

    if ($productResult && mysqli_num_rows($productResult) > 0) {
        $product = mysqli_fetch_assoc($productResult);
        $availableStock = (int)$product['quantity'];

        // Initialize session cart if not set
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Get current session quantity
        $currentSessionQty = isset($_SESSION['cart'][$productId]) ? $_SESSION['cart'][$productId]['quantity'] : 0;
        $newSessionQty = $currentSessionQty + $quantity;

        if ($newSessionQty > $availableStock) {
            $newSessionQty = $availableStock;
        }

        // Update session cart
        $_SESSION['cart'][$productId] = [
            'product_id' => $productId,
            'brand' => $product['brand'],
            'price' => $product['price'],
            'image' => $product['image'],
            'quantity' => $newSessionQty
        ];

        // Check if item already exists in DB cart
        $checkSql = "SELECT quantity FROM cart WHERE product_id = $productId AND customer_id = $customer_id";
        $checkResult = mysqli_query($conn, $checkSql);

        if (mysqli_num_rows($checkResult) > 0) {
            $dbRow = mysqli_fetch_assoc($checkResult);
            $existingDbQty = (int)$dbRow['quantity'];
            $newDbQty = $existingDbQty + $quantity;

            if ($newDbQty > $availableStock) {
                $newDbQty = $availableStock;
            }

            $updateSql = "UPDATE cart SET quantity = $newDbQty WHERE product_id = $productId AND customer_id = $customer_id";
            mysqli_query($conn, $updateSql);
        } else {
            // Insert new record if quantity doesn't exceed stock
            $finalQty = ($quantity > $availableStock) ? $availableStock : $quantity;
            $insertSql = "INSERT INTO cart (product_id, customer_id, quantity) VALUES ($productId, $customer_id, $finalQty)";
            mysqli_query($conn, $insertSql);
        }

        // Calculate total items in session cart
        $totalItems = 0;
        foreach ($_SESSION['cart'] as $item) {
            $totalItems += $item['quantity'];
        }

        echo json_encode([
            'status' => 'success',
            'msg' => 'Product added to cart',
            'total_items' => $totalItems
        ]);
    } else {
        echo json_encode(['status' => 'fail', 'msg' => 'Product not found']);
    }
} else {
    echo json_encode(['status' => 'fail', 'msg' => 'Invalid request']);
}
?>
