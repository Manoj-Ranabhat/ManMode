
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
<style>
    body {
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    margin: 0;
    padding: 0;
   
}

 body {
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    margin: 0;
    padding: 0;
}

.logo {
    position: relative;
    font-size: 50px; /* Logo font size increased */
    font-weight: bold;
    right: 160px;
}

nav {
    height: 90px;
    top: 20px;
    left: 100px;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: rgb(31, 31, 33);
}

nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    align-items: center;
}

nav ul li {
    font-weight: bold;
}

nav ul li a {
    color: white;
    text-decoration: none;
    font-size: 17px;
    padding: 8px 15px;
}

nav ul a:hover {
    background-color: rgb(207, 203, 203);
    color: black;
    border-radius: 4px;
}

nav ul li.logo a {
    font-size: 50px; /* Logo font size */
    color: white;
}

/* Ensure logo doesn't have a hover effect */
nav ul li.logo a:hover {
    background-color: transparent;
    color: white;
    border-radius: 0;
}

/* Cart icon styles */
nav .cart {
    display: flex;
    align-items: center;
    margin-right: 10px;
}

nav .cart i {
    position: relative;
    font-size: 24px;
    color: black;
}

/* Remove hover effect for cart icon */
nav .cart a:hover {
    background-color: transparent;
}

nav .login {
    position: relative;
    left: 500px;
}

/* Styling for large header (if used) */
.H1 {
    margin-left: 60px;
}

</style>
<body>

<nav>
        <ul>
        
            <li class="logo"><a href="#">ManMode</a></li>
            <li><a href="index.php">Home</a></li>
            <li><a href="product.php">Products</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact </a></li>
            <!-- <li><a href="order.php">Orders </a></li> -->
            <li><a href="../customer/customer_login.php">Login</a></li>
            <li><a href="#"><i class="fas fa-shopping-cart"></i></a></li>
        </ul>
    </nav>
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
                        <form onsubmit="return redirectToLogin();"class="add-to-cart-form">
                            <input type="number" class="qty" name="quantity" value="1" min="1" max="<?= $product['quantity'] ?>" required>
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <!-- <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>"> -->
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
<script>
    function redirectToLogin() {
        alert('You have to login to add to cart');
        window.location.href = '../customer/customer_login.php';
        return false;
    }
</script>


</body>
</html>
