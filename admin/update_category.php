<?php
require_once '../connection.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid Category ID'); window.location.href='manage_category.php';</script>";
    exit;
}

$categoryId = $_GET['id'];
$categoryName = "";

// Fetch category data
$sql = "SELECT * FROM category WHERE id = '$categoryId'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $category = mysqli_fetch_assoc($result);
    $categoryName = $category['cat_name'];
} else {
    echo "<script>alert('Category not found'); window.location.href='manage_category.php';</script>";
    exit;
}

// Update category
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newCatName = mysqli_real_escape_string($conn, $_POST['cat_name']);

    $updateSql = "UPDATE category SET cat_name = '$newCatName' WHERE id = '$categoryId'";
    if (mysqli_query($conn, $updateSql)) {
        echo "<script>alert('Category updated successfully'); window.location.href='manage_category.php';</script>";
        exit;
    } else {
        echo "<script>alert('Failed to update category');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Category</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <style>
        body {
            background-color: #f4f7fc;
            font-family: Arial, sans-serif;
            padding: 40px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background-color: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: 500;
            display: block;
            margin-bottom: 6px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 12px;
            width: 100%;
            background-color: #007BFF;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            color: #007BFF;
            text-decoration: none;
            text-align: center;
        }

        .back-btn:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Update Category</h2>

    <form method="POST">
        <div class="form-group">
            <label for="cat_name">Category Name</label>
            <input type="text" id="cat_name" name="cat_name" value="<?php echo htmlspecialchars($categoryName); ?>" required>
        </div>

        <button type="submit">Update Category</button>
    </form>

    <div style="text-align: center;">
        <a class="back-btn" href="manage_category.php">← Back to Categories</a>
    </div>
</div>

</body>
</html>
