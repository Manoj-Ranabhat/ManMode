<?php
require_once '../connection.php';

if(!empty($_POST)){
    $brand = $_POST['brand'];
    // $color = $_POST['color'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $image = '';

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $path = 'uploads/';
        move_uploaded_file($tmp, $path . $image);
    }

    $sql = "INSERT INTO product (brand,  price, category_id, quantity, description, image) VALUES 
    ('$brand',  '$price', '$category_id', '$quantity', '$description', '$image')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "<script>alert('Added successfully');</script>";
    } else {
        echo "<script>alert('Failed to Add');</script>";
    }
}

$categoryOptions = "";
$catsql = "SELECT * FROM category";
$catresult = $conn->query($catsql);

if ($catresult->num_rows > 0) {
    while ($row = $catresult->fetch_assoc()) {
        $categoryOptions .= "<option value='" . $row["id"] . "'>" . $row["cat_name"] . "</option>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="container">
        <div class="form-container">
            <a href="admin_dashboard.php" class="back-btn">Back to Dashboard</a>

            <h2>Add Product</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="brand">Brand</label>
                    <input type="text" id="brand" name="brand" required>
                </div>

                <!-- <div class="form-group">
                    <label for="color">Color</label>
                    <input type="text" id="color" name="color" required>
                </div> -->

                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" required>
                </div>

                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select id="category_id" name="category_id" required>
                        <option value="">Select Category</option>
                        <?php echo $categoryOptions; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="text" id="quantity" name="quantity" required>
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" id="price" name="price" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" required></textarea>
                </div>

                <button type="submit">Add Product</button>
            </form>
        </div>
    </div>

</body>
</html>
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

/* Container */
.container {
    width: 100%;
    max-width: 800px;
    padding: 20px;
    background-color: #fff;
 box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    border-radius: 8px;
       background-color:rgb(239, 239, 241);
}

/* Form Container */
.form-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 24px;
    font-weight: 600;
     color: #00d4ff;
}

/* Back Button */
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

/* Form Group */
.form-group {
    margin-bottom: 15px;
}

.form-group label {
    font-size: 14px;
    font-weight: 500;
    color: #555;
    display: block;
    margin-bottom: 5px;
}

/* Inputs and Textarea */
input[type="text"], 
input[type="file"], 
select, 
textarea {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
}

textarea {
    resize: vertical;
    height: 100px;
}

input[type="file"] {
    padding: 5px;
}

/* Button */
button {
    width: 100%;
    padding: 12px;
    background-color: #009ec3;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background-color: #00d4ff;
}

/* Option List */
select {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        padding: 15px;
    }

    h2 {
        font-size: 20px;
    }

    .form-container {
        padding: 15px;
    }

    button {
        font-size: 14px;
    }
}

</style>