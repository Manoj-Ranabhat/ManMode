<?php
require_once "../connection.php";

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $sql = "SELECT * FROM pending_customers WHERE token = '$token'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        $name = $user['name'];
        $email = $user['email'];
        $password = $user['password'];
        $address = $user['address'];
        $phonenumber = $user['phonenumber'];

        // Insert into final customer table
        $insertQuery = "INSERT INTO customer (name, email, password, address, phonenumber) 
                        VALUES ('$name', '$email', '$password', '$address', '$phonenumber')";
        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            // Delete from pending_customers
            mysqli_query($conn, "DELETE FROM pending_customers WHERE token = '$token'");
            echo "<script>alert('Email verified successfully! You can now log in.');
                  window.location.href='customer_login.php';</script>";
        } else {
            echo "Something went wrong while activating your account.";
        }
    } else {
        echo "Invalid or expired token.";
    }
} else {
    echo "Token is missing.";
}
?>
