<?php
require_once '../connection.php';

if (!empty($_POST)) {
    // $category_id = $_POST['id'];
    $cat_name = $_POST['cat_name'];

    $sql = "INSERT INTO category ( cat_name) VALUES ('$cat_name')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "<script>alert('Category added successfully');</script>";
    } else {
        echo "<script>alert('Failed to add category');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Category</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Global styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f4f7fc;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 500px;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .form-container {
            width: 100%;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            color: #007BFF;
            text-decoration: none;
            font-size: 16px;
        }

        .back-btn:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }

            h2 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <a href="admin_dashboard.php" class="back-btn">← Back to Dashboard</a>
            <h2>Add Category</h2>
            <form action="" method="post">
                <!-- <div class="form-group">
                    <label for="id">Category ID</label>
                    <input type="text" id="id" name="id" required>
                </div> -->

                <div class="form-group">
                    <label for="cat_name">Category Name</label>
                    <input type="text" id="cat_name" name="cat_name" required>
                </div>

                <button type="submit">Add Category</button>
            </form>
        </div>
    </div>
</body>
</html>
