<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>About Us - ManMode</title>
  <link rel="stylesheet" href="css/style.css" />
  <style>
    body {
      font-family: "Segoe UI", sans-serif;
      margin: 0;
      background-color: #f4f4f4;
      color: #222;
    }

    .logo {
      position: relative;
      font-size: 50px;
      /* Logo font size increased */
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
      font-size: 50px;
      /* Logo font size */
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

    .about-header {
      background: #e2dcdc;
      color: #817474;
      text-align: center;
      padding: 50px 20px;
    }

    .about-header h1 {
      font-size: 3rem;
      margin: 0;
    }

    .about-section {
      display: flex;
      flex-wrap: wrap;
      max-width: 1200px;
      margin: 40px auto 90px;
      padding: 0 20px;
      gap: 30px;
      align-items: flex-start;
    }

    .about-image {
      flex: 1;
      min-width: 300px;
    }

    .about-image img {
      position: relative;
      right: 40px;
      width: 100%;
      height: auto;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .about-content {
      flex: 1;
      min-width: 300px;
    }

    .about-content h2 {
      font-size: 2rem;
      color: #333;
      margin-bottom: 20px;
    }

    .about-content p {
      line-height: 1.8;
      margin-bottom: 15px;
    }

    .feature-list {
      margin: 30px 0;
    }

    .feature-list h3 {
      margin-bottom: 15px;
      font-size: 1.5rem;
      color: #444;
    }

    .feature-items {
      display: flex;
      flex-wrap: wrap;
      gap: 10px 20px;
    }

    .feature-items h5 {
      background-color: #fff;
      padding: 10px 15px;
      border-left: 4px solid #222;
      border-radius: 5px;
      font-weight: normal;
      margin: 0;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    
  </style>
</head>

<body>
  <nav>
    <ul>
      <li class="logo"><a href="#" >ManMode</a></li>
      <li><a href="index.php">Home</a></li>
      <li><a href="product.php">Products</a></li>
      <li><a href="about.php">About</a></li>
      <li><a href="contact.php">Contact </a></li>
      <!-- <li><a href="order.php">Orders </a></li> -->
      <li><a href="../customer/customer_login.php">Login</a></li>
      <li>
        <a href="#"><i class="fas fa-shopping-cart"></i></a>
      </li>
    </ul>
  </nav>
  <div class="about-header">
    <h1>About ManMode</h1>
  </div>

  <div class="about-section">
    <div class="about-image">
      <img src="../images/about_banner.png" alt="ManMode About Banner" />
    </div>

    <div class="about-content">
      <h2>Your Destination for Premium Grooming</h2>
      <p>
        At <strong>ManMode</strong>, we believe grooming is more than just
        appearance—it's a statement of confidence, style, and self-care. Our
        curated collection of grooming products is handpicked to elevate your
        routine and empower your personal style.
      </p>

      <p>
        Whether you're looking for the perfect fragrance, skincare solution,
        or haircare essential, ManMode provides top-quality products tailored
        for the modern man. Our personalized recommendation system ensures
        that each product fits your preferences and lifestyle.
      </p>

      <p>
        We are proud to be a one-stop destination for all things
        grooming—because you deserve nothing less than the best version of
        yourself.
      </p>

      <div class="feature-list">
        <h3>Grooming and Confidence Start Here</h3>
        <div class="feature-items">
          <h5>Skin Hydration</h5>
          <h5>Fragrances</h5>
          <h5>Anti-Aging Care</h5>
          <h5>Hair Care</h5>
        </div>
      </div>
    </div>
  </div>
</body>
<?php include_once('includes/footer.php'); ?>

</html>