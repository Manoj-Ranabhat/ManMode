<?php
session_start();

if (isset($_GET['id'])) {
    $productId = $_GET['id'];
}

require_once '../connection.php';

$sql = "SELECT p.id, p.brand,  p.price, p.quantity, p.description, p.image, c.cat_name AS category_name 
        FROM product p
        JOIN category c ON p.category_id = c.id
        WHERE p.id = $productId";

$result = mysqli_query($conn, $sql);
$productData = [];

while ($row = mysqli_fetch_assoc($result)) {
    $productData[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product View</title>
    <link rel="stylesheet" href="../customer/css/customer_view_product.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<?php include_once('../includes/header.php'); ?>

<h1 class="H1">Product/<?= $productData[0]['category_name'] ?></h1>

<div class="container">
    <?php foreach ($productData as $product) { ?>
        <div class="item">
            <div class="image">
                <img src="../admin/uploads/<?= $product['image'] ?>" alt="<?= $product['brand'] ?>">
            </div>
            <div class="title">
                <h1>Brand: <?= $product['brand'] ?></h1>
                <p>Price: <?= $product['price'] ?></p>
                <p>Stock Available: <?= $product['quantity'] ?></p>
                <p>Description: <?= $product['description'] ?></p>

                <div class="buttons">
                    <?php if ($product['quantity'] == 0) { ?>
                        <div class="out-of-stock">Out of stock!!!</div>
                    <?php } else { ?>
                        <form class="add-to-cart-form">
                            <input type="number" class="qty" name="quantity" value="1" min="1" max="<?= $product['quantity'] ?>" required>
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <input type="hidden" name="customer_id" value="<?= $_SESSION['user_id'] ?>">
                            <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                        </form>
                    <?php } ?>
                </div>
            </div> 
        </div>
    <?php } ?>
</div>

<?php include_once('../includes/footer.php'); ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.add-to-cart-form');

    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(form);

            fetch('add_to_cart.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.msg);
                if (data.total_items !== undefined) {
                    document.getElementById('cart-badge').textContent = data.total_items;
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});
</script>

</body>
</html>
