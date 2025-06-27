<?php
session_start();
require_once '../connection.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['invalid'] = ['value' => '❗Please login First', 'timestamp' => time()];
    header('Location: customer_login.php');
    exit;
}

$customer_id = $_SESSION['user_id'];
$productData = [];
$totalPrice = 0;

// Fetch cart products with quantity
$sql = "SELECT cart.cart_id, cart.product_id AS pid, cart.customer_id AS cid, cart.quantity AS cqty,
               product.image, product.price, product.brand 
        FROM cart 
        JOIN product ON product.id = cart.product_id 
        WHERE cart.customer_id = $customer_id";

$cartresult = mysqli_query($conn, $sql);

if (!$cartresult) {
    die("Query failed: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($cartresult)) {
    $totalPrice += $row['price'] * $row['cqty'];
    $productData[] = $row;
}

// Calculate tax and total
$tax = $totalPrice * 0.13; // 13% tax
$shipping = 0;
$total = $totalPrice + $tax;

// Generate transaction UUID for eSewa
function generateRandomString($length = 4): string {
    $characters = '0123456789';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, strlen($characters) - 1)];
    }
    return $randomString;
}

$t_uuid = "TXN-" . generateRandomString();
$message = "total_amount=$total,transaction_uuid=$t_uuid,product_code=EPAYTEST";
$secretKey = "8gBm/:&EnhH.1/q";
$sig = hash_hmac('sha256', $message, $secretKey, true);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="css/customer_view_cart.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<?php include_once('../includes/header.php'); ?>

<div class="cart-container">
    <div class="table-container">
        <h1>Shopping Cart</h1>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productData as $product) { ?>
                    <tr>
                        <td><?= htmlspecialchars($product['brand']) ?></td>
                        <td><img src="../images/<?= htmlspecialchars($product['image']) ?>" alt="Product Image" style="width: 80px;"></td>
                        <td>Rs <?= htmlspecialchars($product['price']) ?></td>
                        <td><?= htmlspecialchars($product['cqty']) ?></td>
                        <td>
                            <a href="./cart_item_delete.php?cid=<?= $product['cart_id'] ?>" class="del">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Checkout Summary -->
    <div class="checkout-summary">
        <h1>Order Summary</h1><hr>
        <p><strong>Subtotal:</strong> Rs <?= $totalPrice ?></p><hr>
        <p><strong>Tax (13%):</strong> Rs <?= $tax ?></p><hr>
        <p><strong>Total:</strong> Rs <?= $total ?></p><hr>
        <form action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST">
            <input type="hidden" name="amount" value="<?= $totalPrice ?>">
            <input type="hidden" name="tax_amount" value="<?= $tax ?>">
            <input type="hidden" name="total_amount" value="<?= $total ?>">
            <input type="hidden" name="transaction_uuid" value="<?= $t_uuid ?>">
            <input type="hidden" name="product_code" value="EPAYTEST">
            <input type="hidden" name="product_service_charge" value="0">
            <input type="hidden" name="product_delivery_charge" value="<?= $shipping ?>">
            <input type="hidden" name="success_url" value="http://localhost/Ecommerce-project/customer/checkout2.php">
            <input type="hidden" name="failure_url" value="http://localhost/Ecommerce-project/customer/status_fail.php">
            <input type="hidden" name="signed_field_names" value="total_amount,transaction_uuid,product_code">
            <input type="hidden" name="signature" value="<?= base64_encode($sig) ?>">
            <button>Proceed to Checkout</button>
        </form>
    </div>
</div>

<?php include_once('../includes/footer.php'); ?>
</body>
</html>
