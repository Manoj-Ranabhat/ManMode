<?php
require_once '../connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

if (!empty($_POST)) {
    $brand = $_POST['brand'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $image = $_POST['old_image'];

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $path = 'uploads/';
        move_uploaded_file($tmp, $path . $image);
    }

    $sql = "UPDATE product SET brand='$brand', price='$price',
    category_id='$category_id', quantity='$quantity',
    description='$description', image='$image' WHERE id=$id";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "<script>alert('Updated successfully');</script>";
        echo "<script>window.location.href='products.php';</script>";
        exit;
    } else {
        echo "<script>alert('Failed to Update');</script>";
    }
}

// Fetch categories
$categoryOptions = "";
$catsql = "SELECT * FROM category";
$catresult = $conn->query($catsql);
if ($catresult->num_rows > 0) {
    while ($cat = $catresult->fetch_assoc()) {
        $categoryOptions .= "<option value='" . $cat["id"] . "'>" . $cat["cat_name"] . "</option>";
    }
}

// Fetch product data
$updatesql = "SELECT * FROM product WHERE id=$id";
$updateresult = mysqli_query($conn, $updatesql);

while ($row = mysqli_fetch_assoc($updateresult)) {
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Edit Product</title>
        <style>
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
                background-color: rgb(239, 239, 241);
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
                width: 700px;
            }

            h2 {
                text-align: center;
                margin-bottom: 25px;
                color: #00d4ff;
            }

            label {
                /* font-weight: bold; */
                display: block;
                margin-bottom: 5px;
                margin-top: 15px;
                color: black;
            }

            input[type="text"],
            select,
            input[type="file"] {
                width: 100%;
                padding: 10px;
                border-radius: 6px;
                border: none;
                margin-bottom: 10px;
                background-color: rgb(230, 230, 236);
                color: rgb(14, 0, 0);
            }

            input[type="text"]:focus,
            select:focus {
                outline: none;
                border: 1px solid black;
            }

            img {
                width: 120px;
                margin-top: 10px;
                border-radius: 4px;
            }

            .button-group {
                display: flex;
                gap: 10px;
                margin-top: 20px;
            }

            button {
                flex: 1;
                padding: 12px;

                background-color: #009ec3;
                color: #fff;
                font-weight: bold;
                border: none;
                border-radius: 6px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            button:hover {
                background-color: #00d4ff;
            }

            .back-btn {
                background-color: #555;
            }

            .back-btn:hover {
                background-color: #444;
            }
        </style>
    </head>

    <body>

        <div class="container">
            <h2>Edit Product</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <label for="brand">Brand</label>
                <input type="text" id="brand" name="brand" value="<?= $row['brand'] ?>">

                <label for="image">Image</label>
                <input type="file" name="image">
                <img src="uploads/<?= $row['image'] ?>" alt="Current Image">
                <input type="hidden" name="old_image" value="<?= $row['image'] ?>">

                <label for="category_id">Category</label>
                <select id="category_id" name="category_id">
                    <option value="">Select Category</option>
                    <?= str_replace("value='" . $row['category_id'] . "'", "value='" . $row['category_id'] . "' selected", $categoryOptions); ?>
                </select>

                <label for="quantity">Quantity</label>
                <input type="text" id="quantity" name="quantity" value="<?= $row['quantity'] ?>">

                <label for="price">Price</label>
                <input type="text" id="price" name="price" value="<?= $row['price'] ?>">

                <label for="description">Description</label>
                <input type="text" id="description" name="description" value="<?= $row['description'] ?>">

                <div class="button-group">
                    <a href="admin_dashboard.php"><button type="button" class="back-btn">Back</button></a>
                    <button type="submit">Update</button>
                </div>
            </form>
        </div>

    </body>

    </html>

<?php } ?>