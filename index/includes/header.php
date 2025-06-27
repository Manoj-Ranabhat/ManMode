<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Document</title>
</head>
<body>
<nav>
        <ul>
        
            <li class="logo"><a href="#">ManMode</a></li>
            <li><a href="customer_index.php">Home</a></li>
            <li><a href="product.php">Products</a></li>
            <li><a href="customer_about.php">About</a></li>
            <li><a href="customer_contact.php">Contact </a></li>
            <li><a href="order.php">Orders </a></li>
            <li><a href="../index/index.php">Logout</a></li>
            <li><a href="customer_view_cart.php"><i class="fas fa-shopping-cart"></i></a></li>
        </ul>
    </nav>
</body>
</html>
<style>
    body {
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
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
        /* top: 20px; */
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
</style>