<?php

require_once '../vendor/autoload.php';

$auth = new \App\Authenticate();
$auth->signUp();

$auth->redirectIfAuth();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/index.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet'
          href='https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap'>
    <title>Sign Up</title>
</head>

<body class="signup-page">

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/IA_HU_2026/pages/Layout/Navbar.php' ?>


<form method="post" class="signup-form">
    <div class="Login-Card">
        <div class="screen-1">

            <div class="email">
                <label for="usernameID">Username</label>
                <div class="sec-2">
                    <ion-icon name="person-outline" aria-hidden="true"></ion-icon>
                    <input autocomplete="off" id="usernameID" required type="text" name="username" placeholder="Ahmed Arafat"/>
                </div>
            </div>
            <div class="email">
                <label for="emailID">Email</label>
                <div class="sec-2">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input autocomplete="off" id="emailID" type="email" required name="email" placeholder="ahmed@gmail.com"/>
                </div>
            </div>

            <div class="password">
                <label for="passwordID">Password</label>
                <div class="sec-2">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <input class="pas" id="passwordID" required type="password" name="password"/>
                </div>
            </div>

            <div class="password">
                <label for="passwordConfirmationID">Confirm Password</label>
                <div class="sec-2">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <input class="pas" id="passwordConfirmationID" required type="password" name="confirm_password"/>
                </div>
            </div>
            <button type="submit" name="signUpBtn" class="login">Sign Up</button>
            <div class="footer">
                <a href="SignIn.php">
                    Sign In
                </a>
                <span>Forgot Password?</span>
            </div>

        </div>
    </div>
</form>

</body>

</html>

