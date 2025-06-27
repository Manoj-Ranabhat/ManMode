

<?php
session_start();

require_once "../connection.php";

if (!empty($_POST)) {
    $email = $_POST['email'];
    $password = $_POST['password']; // Note: Don't apply md5 hashing here yet

    // Validation
    $errors = [];
    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required";
    }elseif(strlen($password)<8){
        $errors['password']="Password must be more than 8 characters";
    }

    if (empty($errors)) {
        // Sanitize input
        $email = mysqli_real_escape_string($conn, $email);

        // Hash the password
       $password =$_POST['password'];

        // Proceed with the SQL query
        $sql = "SELECT * FROM admin WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($conn, $sql);
        $num_of_rows = mysqli_num_rows($result);

        if ($num_of_rows > 0) {
            // User authentication successful
            $admin = mysqli_fetch_assoc($result);
            $_SESSION['admin_name'] = $admin['id'];
            $_SESSION['is_login'] = true;
            header('Location:admin_dashboard.php');
            exit;
        } else {
            $_SESSION['error'] = "Invalid email or password";
        }
    } else {
        // Set session errors
        $_SESSION['validation_errors'] = $errors;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../admin/css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <?php if (isset($_SESSION['error'])): ?>
            <script>
                alert('<?php echo $_SESSION['error']; unset($_SESSION['error']); ?>');
            </script>
        <?php endif; ?>

        <div class="content">
            <h1 class="main-heading">ManMode</h1>
            <div class="welcome-message">
                <p>Welcome to ManMode</p>
            </div>

            <form action="" method="post">

                <!-- Email Field -->
                <div class="input-wrapper">
                    <div class="input-container">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="Email"
                            value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                    </div>
                    <?php if (isset($_SESSION['validation_errors']['email'])): ?>
                        <span class="error"><?= $_SESSION['validation_errors']['email']; unset($_SESSION['validation_errors']['email']); ?></span>
                    <?php endif; ?>
                </div>

                <!-- Password Field -->
                <div class="input-wrapper">
                    <div class="input-container">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Password"
                            value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>">
                    </div>
                    <?php if (isset($_SESSION['validation_errors']['password'])): ?>
                        <span class="error"><?= $_SESSION['validation_errors']['password']; unset($_SESSION['validation_errors']['password']); ?></span>
                    <?php endif; ?>
                </div>

                <button>Login</button>
            </form>
        </div>
    </div>
</body>

</html>


<!-- <div class="image">
            <img src="../images/about_banner.png" alt="" class="src">
        </div> -->