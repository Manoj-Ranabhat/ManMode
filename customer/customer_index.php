
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Project</title>
    <link rel="stylesheet" href="../customer/css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>


<?php include_once('../includes/header.php'); ?>

<!-- <link rel="stylesheet" href="../css/home.css"> -->

<!-- Hero Section -->
<div class="hero-section">
    <img src="../images/gpt_banner.png" alt="Grooming Products" class="hero-image">
    
</div>

<!-- Info Cards Section -->
<div class="info-section">
    
    <div class="info-card">
        <h2>Come Know more about Us!</h2>
        <p>Best Grooming products: haircare, fragrances, skincare for men and more.</p>
        <a href="customer_about.php" class="info-btn">ABOUT US</a>
    </div>

    <div class="info-card">
        <h2>Have a look towards our newly arrival products</h2>
        <p>Best products at your home providing grooming products of different brands.</p>
        <a href="product.php" class="info-btn">GET A PRODUCT</a>
    </div>

</div>
<div class="delivery">
    <div class="icon">
        <img class="img1" src="../images/delivery.webp" alt="" class="src">
        <img class="img2" src="../images/shopping.jpg" alt="" class="src">
        <img class="img3" src="../images/payment.jpg" alt="" class="src">
    </div>

    <div class="p">
        <p>"Enjoy fast and safe delivery with every order, ensuring your products
            arrive quickly and securely right to your doorstep."</p>
        <p>"Discover the ease of online shopping with a wide selection of products available
            at your fingertips, anytime and anywhere."</p>
        <p>"Experience secure and convenient online payment options, making your transactions
            smooth and worry-free."</p>
    </div><hr>
    </div>

    <?php include_once('../includes/footer.php'); ?>
</body>
</html>
