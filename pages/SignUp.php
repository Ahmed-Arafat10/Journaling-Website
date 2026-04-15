<?php

use App\Authenticate;

require_once '../vendor/autoload.php';

$auth = new Authenticate();
$auth->signUp();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="\viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/index.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet'
          href='https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap'>
    <title>Sign Up</title>
</head>

<body>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/IA/pages/Layout/Navbar.php'; ?>

<form method="post">
    <div class="Login-Card">
        <div class="screen-1">

            <h2 class="title">Create Account</h2>

            <div class="input-group">
                <ion-icon name="person-outline"></ion-icon>
                <input autocomplete="off" id="username" required type="text" name="username" placeholder="Username">
            </div>

            <div class="input-group">
                <ion-icon name="mail-outline"></ion-icon>
                <input autocomplete="off" required type="email" name="email" placeholder="Email Address">
            </div>

            <div class="input-group password-group">
                <ion-icon name="lock-closed-outline"></ion-icon>
                <input id="password" required type="password" name="password" placeholder="Password">
                <ion-icon id="togglePassword" class="toggle" name="eye-outline"></ion-icon>
            </div>

            <div class="input-group password-group">
                <ion-icon name="lock-closed-outline"></ion-icon>
                <input id="confirmPassword" required type="password" name="confirm_password" placeholder="Confirm Password">
                <ion-icon id="toggleConfirm" class="toggle" name="eye-outline"></ion-icon>
            </div>

            <small id="matchMessage"></small>

            <button type="submit" name="signUpBtn" class="login">Sign Up</button>

            <div class="footer">
                <p>Already have an account? <a href="SignIn.php">Log In</a></p>
            </div>

        </div>
    </div>
</form>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/IA/pages/Layout/Footer.php') ?>
</body>

</html>

