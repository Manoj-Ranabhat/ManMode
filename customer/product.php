<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../connection.php';

if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fuzzy match algorithm

// Fuzzy match algorithm with synonym support
function isFuzzyMatch($needle, $haystack, $threshold = 2) {
    $needle = strtolower($needle);
    $haystack = strtolower($haystack);

    // Step 1: Synonym normalization
    $synonyms = [
        'scent' => 'fragrances',
        'perfume' => 'fragrances',
        'face' => 'skincare',
        'facewash' => 'skincare',
        'moisturizer' => 'skincare',
        'cream' => 'haircream',
        'gel' => 'haircream',
        'smell' => 'fragrances',
        'deodorant' => 'fragrances',
        // Add more as needed
    ];

    // Normalize the search term
    if (isset($synonyms[$needle])) {
        $needle = $synonyms[$needle];
    }

    // Exact partial match
    if (stripos($haystack, $needle) !== false) {
        return true;
    }

    // Apply Levenshtein only if lengths are similar
    if (abs(strlen($needle) - strlen($haystack)) <= 3) {
        $distance = levenshtein($needle, $haystack);
        return $distance <= $threshold;
    }

    return false;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Products</title>
  <link rel="stylesheet" href="./css/product.css">
</head>
<body>

<?php include_once('../includes/header.php'); ?>

<div class="product-container">
  <h1>Products</h1>

  <!-- Search and Filter Form -->
  <form class="search-form" method="GET" action="product.php">
    <input type="text" name="query" placeholder="Search for products..." value="<?= isset($_GET['query']) ? htmlspecialchars($_GET['query']) : '' ?>">
    <select name="category">
      <option value="all" <?= (isset($_GET['category']) && $_GET['category'] === 'all') ? 'selected' : '' ?>>All Categories</option>
      <option value="fragrances" <?= (isset($_GET['category']) && $_GET['category'] === 'fragrances') ? 'selected' : '' ?>>Fragrances</option>
      <option value="haircream" <?= (isset($_GET['category']) && $_GET['category'] === 'haircream') ? 'selected' : '' ?>>Hair Cream</option>
      <option value="skincare" <?= (isset($_GET['category']) && $_GET['category'] === 'skincare') ? 'selected' : '' ?>>Skin Care</option>
    </select>
    <button type="submit">Search</button>
  </form>

  <?php
  $query = isset($_GET['query']) ? $_GET['query'] : '';
  $category = isset($_GET['category']) ? $_GET['category'] : 'all';

  // ------------------ Highly Recommended Section ------------------
  $recommended_sql = "SELECT p.*, c.cat_name
                      FROM product p
                      LEFT JOIN category c ON p.category_id = c.id
                      WHERE p.purchase_count >= 10";

  if ($category !== 'all') {
      $recommended_sql .= " AND c.cat_name = '" . mysqli_real_escape_string($conn, $category) . "'";
  }

  $recommended_result = mysqli_query($conn, $recommended_sql);

  if ($recommended_result && mysqli_num_rows($recommended_result) > 0) {
      $recommended_displayed = false;
      while ($row = mysqli_fetch_assoc($recommended_result)) {
          // Apply fuzzy search across brand, description, and category
          if (!empty($query) && !(
              isFuzzyMatch($query, $row['brand']) ||
              isFuzzyMatch($query, $row['description']) ||
              isFuzzyMatch($query, $row['cat_name'])
          )) {
              continue;
          }

          if (!$recommended_displayed) {
              echo '<h2 class="section-heading">🔥 Highly Recommended Products</h2>';
              echo '<div class="products-list">';
              $recommended_displayed = true;
          }

          echo '<a href="customer_view_product.php?id=' . $row['id'] . '" style="text-decoration: none; color: inherit;">';
          echo '<div class="product-card">';
          echo '<img src="../admin/uploads/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['brand']) . '">';
          echo '<h3>' . htmlspecialchars($row['brand']) . '</h3>';
          echo '<span class="badge">Highly Recommended</span>';
          echo '<p>' . htmlspecialchars($row['description']) . '</p>';
          echo '<div class="price">Rs. ' . number_format($row['price'], 2) . '</div>';
          echo '</div></a>';
      }

      if ($recommended_displayed) {
          echo '</div>';
      }
  }

  // ------------------ All Products Section ------------------
  echo '<h2 class="section-heading">All Products</h2>';
  echo '<div class="products-list">';

  $sql = "SELECT p.*, c.cat_name
          FROM product p
          LEFT JOIN category c ON p.category_id = c.id
          WHERE 1";

  if ($category !== 'all') {
      $sql .= " AND c.cat_name = '" . mysqli_real_escape_string($conn, $category) . "'";
  }

  $result = mysqli_query($conn, $sql);

  if (!$result) {
      die("SQL Error: " . mysqli_error($conn));
  }

  $matchFound = false;
  if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
          // Apply fuzzy search across brand, description, and category
          if (!empty($query) && !(
              isFuzzyMatch($query, $row['brand']) ||
              isFuzzyMatch($query, $row['description']) ||
              isFuzzyMatch($query, $row['cat_name'])
          )) {
              continue;
          }

          $matchFound = true;
          echo '<a href="customer_view_product.php?id=' . $row['id'] . '" style="text-decoration: none; color: inherit;">';
          echo '<div class="product-card">';
          echo '<img src="../admin/uploads/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['brand']) . '">';
          echo '<h3>' . htmlspecialchars($row['brand']) . '</h3>';
          echo '<p>' . htmlspecialchars($row['description']) . '</p>';
          echo '<div class="price">Rs. ' . number_format($row['price'], 2) . '</div>';
          echo '</div></a>';
      }
  }

  if (!$matchFound) {
      echo '<p>No products found.</p>';
  }

  echo '</div>';
  ?>

</div>

<?php include_once('../includes/footer.php'); ?>
</body>
</html>
