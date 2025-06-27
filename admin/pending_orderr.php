<?php
session_start();
require('../connection.php');

// if (!isset($_SESSION['user_id'])) {
//     die("User is not logged in.");
// }

if (isset($_POST['complete_order']) && isset($_POST['id'])) {
    $order_id = $_POST['id'];
    $query = "UPDATE orders SET status = 'completed' WHERE order_id = $order_id";
    $res = mysqli_query($conn, $query);
}

// Filter orders based on status
$statusFilter = isset($_POST['status_filter']) ? $_POST['status_filter'] : 'Pending';
$sql = "SELECT orders.*, product.image, product.category_id, category.cat_name FROM orders 
        JOIN product ON orders.product_id = product.id 
        JOIN category ON product.category_id = category.id 
        WHERE orders.status = '$statusFilter'";


$result = mysqli_query($conn, $sql);
$orderItems = [];
while ($row = mysqli_fetch_assoc($result)) {
    $orderItems[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }

        header {
            background-color: rgb(245, 241, 241);
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        header .logo {
            font-size: 24px;
            font-weight: bold;
        }

        button,
        select {
            background-color: #2c3e50;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-left: 10px;
            transition: background-color 0.3s ease;
        }

        button:hover,
        select:hover {
            background-color: #34495e;
        }

        .button-container {
            margin: 20px;
            display: flex;
            justify-content: flex-start;
        }

        select:focus {
            border: 2px solid #f39c12;
        }

        .table-container {
            margin: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            max-height: 500px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #2b2b39;
            color: #fff;
            text-transform: uppercase;
            font-size: 14px;
            border-right: 1px solid white;

            position: sticky;
            top: 0;
            z-index: 2;
        }


        td {
            background-color: #f9f9f9;
        }

        td img {
            width: 50px;
            border-radius: 5px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e5e5e5;
        }

        .status {
            display: flex;
            gap: 10px;
        }

        .submit {
            background-color: #27ae60;
        }

        .submit:hover {
            background-color: #2ecc71;
        }

        .cancel {
            background-color: #e74c3c;
        }

        .cancel:hover {
            background-color: #c0392b;
        }

        h1 {
            font-size: 32px;
            color: #2c3e50;
            margin-top: 40px;
            text-align: center;
        }

        a {
            text-decoration: none;
        }

        a button {
            background-color: #34495e;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        a button:hover {
            background-color: #2c3e50;
        }
    </style>
</head>
<!DOCTYPE html>
<html lang="en">

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
            <li><a href="manage_category.php">Manage Category</a></li>
        </ul>
    </div>
    <div class="main-content" id="main-content">
        <header>
            <button class="toggle-btn" id="toggle-btn">☰</button>
            <h1>Welcome, Admin</h1>
        </header>

        <body>
            <div class="button-container">
                <form action="" method="post">
                    <select name="status_filter" onchange="this.form.submit()">
                        <option value="pending" <?= $statusFilter == 'pending' ? 'selected' : '' ?>>Pending Orders</option>
                        <option value="completed" <?= $statusFilter == 'completed' ? 'selected' : '' ?>>Completed Orders
                        </option>
                        <option value="canceled" <?= $statusFilter == 'canceled' ? 'selected' : '' ?>>Canceled Orders
                        </option>
                    </select>
                </form>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Customer_Id</th>
                            <th>Category</th>
                            <th>Product-Name</th>
                            <th>Image</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0;
                        foreach ($orderItems as $row): ?>

                            <tr>
                                <td><?= ++$i ?></td>
                                <td><?= $row['customer_id'] ?></td>
                                <td><?= $row['cat_name'] ?></td>
                                <td><?= $row['product_name'] ?></td>
                                <td><img src="../admin/uploads/<?= $row['image'] ?>" width="50" alt=""></td>
                                <td class="status">
                                    <?= $row['status'] ?>
                                    <?php if ($row['status'] == 'pending') { ?>
                                        <form action="" method="post" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= $row['order_id'] ?>">
                                            <button class="submit" type="submit" name="complete_order">Complete</button>
                                        </form>
                                    <?php } elseif ($row['status'] == 'canceled') { ?>
                                        <form action="cancel_order.php" method="post" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= $row['order_id'] ?>">
                                            <button class="cancel" type="submit" name="cancel_order">Remove Order</button>
                                        </form>
                                    <?php } ?>
                                </td>


                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <a href="admin_dashboard.php"><button>Back</button></a>
        </body>

</html>
<script>
    document.getElementById('toggle-btn').addEventListener('click', function () {
        document.getElementById('sidebar').classList.toggle('active');
        document.getElementById('main-content').classList.toggle('active');
    });
</script>