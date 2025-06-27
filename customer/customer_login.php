<?php
session_start();
require_once "../connection.php";

if (!empty($_POST)) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $errors = [];

    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required";
    } elseif (strlen($password) < 8) {
        $errors['password'] = "Password must be more than 8 characters";
    }

    if (empty($errors)) {
        $email = mysqli_real_escape_string($conn, $email);
        $password = md5($password);

        $sql = "SELECT * FROM customer WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($conn, $sql);
        $num_of_rows = mysqli_num_rows($result);

        if ($num_of_rows > 0) {
            $user = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['users_name'] = $user['name'];
            $_SESSION['is_login'] = true;
            header('Location: customer_index.php');
            exit;
        } else {
            $_SESSION['error'] = "Invalid email or password";
        }
    } else {
        $_SESSION['validation_errors'] = $errors;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - ManMode</title>
    <link rel="stylesheet" href="../customer/css/customer_login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Background index.php as iframe -->
    <iframe src="../index/index.php" frameborder="0" class="background-frame"></iframe>

    <div class="container">
        <a href="../index/index.php" class="close-btn" title="Close">&times;</a>
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
                <div class="input-container">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email" value="<?= isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                    <?php if(isset($_SESSION['validation_errors']['email'])): ?>
                        <span class="error"><?= $_SESSION['validation_errors']['email']; unset($_SESSION['validation_errors']['email']); ?></span>
                    <?php endif; ?>
                </div>

                <div class="input-container">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" value="<?= isset($_POST['password']) ? $_POST['password'] : ''; ?>">
                    <?php if(isset($_SESSION['validation_errors']['password'])): ?>
                        <span class="error"><?= $_SESSION['validation_errors']['password']; unset($_SESSION['validation_errors']['password']); ?></span>
                    <?php endif; ?>
                </div>

                <button type="submit">Login</button>
                <h4>Don't Have an Account? <a href="customer_register.php">Signup</a></h4>
            </form>
        </div>
    </div>
</body>
</html>
