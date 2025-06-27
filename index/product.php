<?php
// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include '../connection.php'; // Change path if needed

// Check if the database connection is successful
if (mysqli_connect_errno()) {
  die("Connection failed: " . mysqli_connect_error());
}
?>
<style>
  body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #fff;
    margin: 0;
    padding: 0;

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

  body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #fff;
    margin: 0;
    padding: 0;
    text-align: center;
  }

  .product-container {
    padding: 40px 20px;
    margin-bottom: 50px;
  }

  .product-container h1 {
    font-size: 48px;
    color: #7aa3c4;
    margin-bottom: 30px;
  }

  .section-heading {
    font-size: 28px;
    color: #2b8a3e;
    margin-top: 40px;
    margin-bottom: 20px;
  }

  .search-form {
    display: flex;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 30px;
  }

  .search-form input[type="text"],
  .search-form select {
    padding: 10px 15px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 16px;
    min-width: 200px;
  }

  .search-form button {
    background-color: #54c3dc;
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
  }

  .products-list {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 20px;
  }

  .product-card {
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 10px;
    background-color: #f9f9f9;
    width: 220px;
    text-align: center;
    position: relative;
  }

  .product-card img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 8px;
  }

  .product-card h3 {
    margin: 10px 0 5px;
    font-size: 18px;
  }

  .product-card p {
    font-size: 14px;
    color: #555;
  }

  .product-card .price {
    margin-top: 10px;
    color: #2b8a3e;
    font-weight: bold;
  }

  .badge {
    display: inline-block;
    background-color: #2b8a3e;
    color: white;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 12px;
    margin-top: 5px;
  }
</style>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Products</title>

</head>
<script>
  function loginAlert() {
    alert("You must be logged in to view product details.");
    window.location.href = "../customer/customer_login.php";
  }
</script>

<body>
  <nav>
    <ul>

      <li class="logo"><a href="#" style="float: left;">ManMode</a></li>
      <li><a href="index.php">Home</a></li>
      <li><a href="product.php">Products</a></li>
      <li><a href="about.php">About</a></li>
      <li><a href="contact.php">Contact </a></li>
      <!-- <li><a href="order.php">Orders </a></li> -->
      <li><a href="../customer/customer_login.php">Login</a></li>
      <li><a href="#"><i class="fas fa-shopping-cart"></i></a></li>
    </ul>
  </nav>
  <div class="product-container">
    <h1>Products</h1>

    <!-- Search and Filter Form -->
    <form class="search-form" method="GET" action="product.php">
      <input type="text" name="query" placeholder="Search for products..."
        value="<?= isset($_GET['query']) ? htmlspecialchars($_GET['query']) : '' ?>">
      <select name="category">
        <option value="all" <?= (isset($_GET['category']) && $_GET['category'] === 'all') ? 'selected' : '' ?>>All
          Categories</option>
        <option value="fragrances" <?= (isset($_GET['category']) && $_GET['category'] === 'Fragrances') ? 'selected' : '' ?>>Fragrances</option>
        <option value="haircream" <?= (isset($_GET['category']) && $_GET['category'] === 'Haircream') ? 'selected' : '' ?>>
          Hair Cream</option>
        <option value="skincare" <?= (isset($_GET['category']) && $_GET['category'] === 'SkinCare') ? 'selected' : '' ?>>
          Skin Care</option>
      </select>
      <button type="submit">Search</button>
    </form>

    <!-- Highly Recommended Products -->
    <?php
    $query = isset($_GET['query']) ? $_GET['query'] : '';
    $category = isset($_GET['category']) ? $_GET['category'] : 'all';

    $recommended_sql = "SELECT p.*, c.cat_name
                      FROM product p
                      LEFT JOIN category c ON p.category_id = c.id
                      WHERE p.purchase_count >= 10";

    if ($category !== 'all') {
      $recommended_sql .= " AND c.cat_name = '" . mysqli_real_escape_string($conn, $category) . "'";
    }

    if (!empty($query)) {
      $recommended_sql .= " AND p.brand LIKE '%" . mysqli_real_escape_string($conn, $query) . "%'";
    }

    $recommended_result = mysqli_query($conn, $recommended_sql);

    if ($recommended_result && mysqli_num_rows($recommended_result) > 0) {
          echo '<h2 class="section-heading">🔥 Highly Recommended Products</h2>';
      echo '<div class="products-list">';
      while ($row = mysqli_fetch_assoc($recommended_result)) {

        echo '<a href="index_view_product.php?id=' . $row['id'] . '" style="text-decoration: none; color: inherit;">';
        echo '<div class="product-card">';
        echo '<img src="../admin/uploads/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['brand']) . '">';
        echo '<h3>' . htmlspecialchars($row['brand']) . '</h3>';
        echo '<span class="badge">Highly Recommended</span>';
        echo '<p>' . htmlspecialchars($row['description']) . '</p>';
        echo '<div class="price">Rs. ' . number_format($row['price'], 2) . '</div>';
        echo '</div></a>';
      }
      echo '</div>';
    }
    ?>

    <!-- All Products -->
    <h2 class="section-heading">All Products</h2>
    <div class="products-list">
      <?php
      $sql = "SELECT p.*, c.cat_name
            FROM product p
            LEFT JOIN category c ON p.category_id = c.id
            WHERE 1";

      if ($category !== 'all') {
        $sql .= " AND c.cat_name = '" . mysqli_real_escape_string($conn, $category) . "'";
      }

      if (!empty($query)) {
        $sql .= " AND p.brand LIKE '%" . mysqli_real_escape_string($conn, $query) . "%'";
      }

      // $sql .= " ORDER BY p.id DESC";
      
      $result = mysqli_query($conn, $sql);

      if (!$result) {
        die("SQL Error: " . mysqli_error($conn));
      }

      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo '<a href="index_view_product.php?id=' . $row['id'] . '" style="text-decoration: none; color: inherit;">';
          echo '<div class="product-card">';
          echo '<img src="../admin/uploads/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['brand']) . '">';
          echo '<h3>' . htmlspecialchars($row['brand']) . '</h3>';
          // if ($row['purchase_count'] >= 10) {
          //     echo '<span class="badge">Highly Recommended</span>';
          // }
          echo '<p>' . htmlspecialchars($row['description']) . '</p>';
          echo '<div class="price">Rs. ' . number_format($row['price'], 2) . '</div>';
          echo '</div></a>';
        }
      } else {
        echo '<p>No products found.</p>';
      }
      ?>
    </div>
  </div>

 
</body>
<?php include_once('includes/footer.php'); ?>
</html>

