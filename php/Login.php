<?php

use App\DB;

require_once $_SERVER['DOCUMENT_ROOT'] . '/Journaling/vendor/autoload.php';

DB::connect();
//DB::check();

\App\Authentication::IsUserLoggedIn();


\App\Authentication::logIn();

\App\Alert::alertAfterSignUp();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/index.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <!--    icons   -->
    <!--    icons   -->
    <!--    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>-->
    <!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">-->
    <link rel='stylesheet'
          href='https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap'>
</head>

<body>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/Journaling/php/Layout/NavBar.php' ?>

<form method="POST">
    <div class="Login-Card">
        <div class="screen-1">

            <div class="email">
                <label for="email">Username</label>
                <div class="sec-2">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input required type="text" name="Username" placeholder="EX: Ahmed"/>
                </div>
            </div>

            <div class="password">
                <label for="password">Password</label>
                <div class="sec-2">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <input required class="pas" type="password" name="Password" placeholder="·········"/>
                    <!-- <ion-icon class="show-hide" name="eye-outline"></ion-icon> -->
                </div>
            </div>

            <div class="rememberme">
                <input type="checkbox" name="RememberMe" id="" value="1">
                <label for="">Remember Me</label>
            </div>

            <button type="submit" name="logInBtn" class="login">Login</button>

            <div class="footer">
                <a href="<?php echo '/Journaling/php/SignUp.php' ?>">
                    Sign Up
                </a>
                <span>Forgot Password?</span>
            </div>

        </div>
</form>
<!-- Div That Contains Form Of Sigining In End -->

<?php \App\Html::getScripts(); ?>
</body>
</html>