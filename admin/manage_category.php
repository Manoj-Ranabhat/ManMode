<?php
require_once '../connection.php';

// Handle delete action
if (isset($_GET['delete'])) {
    $deleteId = $_GET['delete'];
    $delSql = "DELETE FROM category WHERE id = '$deleteId'";
    mysqli_query($conn, $delSql);
    echo "<script>alert('Category deleted successfully'); window.location.href='manage_category.php';</script>";
}

// Fetch categories
$categories = [];
$sql = "SELECT * FROM category ORDER BY id ASC";
$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Categories</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: #f4f7fc;
            font-family: Arial, sans-serif;
            
        }

        .container {
            position: relative;
            top:150px;
            width:1200px;
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

        .add-btn {
            display: inline-block;
            padding: 10px 15px;
            margin-bottom: 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .add-btn:hover {
            background-color: #218838;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            text-align: center;
            padding: 12px;
        }

        th {
            background-color: #2b2b39;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .action-btn {
            padding: 6px 12px;
            margin: 2px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
        }

        .edit-btn {
            background-color: #ffc107;
        }

        .edit-btn:hover {
            background-color: #e0a800;
        }

        .delete-btn {
            background-color: #dc3545;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="css/user.css"> -->
    <link rel="stylesheet" href="css/dashboard.css">
    <title>Admin Dashboard</title>
</head>

<body>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h2>Admin Dashboard</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="admin_dashboard.php"> Dashboard</a></li>
            <li><a href="add_product.php">Add Products</a></li>
            <li><a href="user.php">Users</a></li>
            <li><a href="pending_orderr.php">Orders</a></li>
            <li><a href="products.php">Products</a></li>
        </ul>
    </div>
    <div class="main-content" id="main-content">
        <header>
            <button class="toggle-btn" id="toggle-btn">☰</button>
            <h1>Welcome, Admin</h1>
        </header>

<div class="container">
    <h2>Manage Categories</h2>

    <a class="add-btn" href="category.php">+ Add Category</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (count($categories) > 0): ?>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?php echo $category['id']; ?></td>
                    <td><?php echo htmlspecialchars($category['cat_name']); ?></td>
                    <td>
                        <a class="action-btn edit-btn" href="update_category.php?id=<?php echo $category['id']; ?>">Edit</a>
                        <a class="action-btn delete-btn" href="manage_category.php?delete=<?php echo $category['id']; ?>" onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="3">No categories found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
<script>
    document.getElementById('toggle-btn').addEventListener('click', function() {
    document.getElementById('sidebar').classList.toggle('active');
    document.getElementById('main-content').classList.toggle('active');
});

</script>
</html>
