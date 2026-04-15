<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/index.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <!--    icons   -->
    <!--    icons   -->
    <!--    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>-->
    <!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">-->
    <link rel='stylesheet'
          href='https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap'>
    <title>Sign In</title>
</head>

<body>

<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/IA/pages/Layout/Navbar.php') ?>

<form method="post">
    <div class="Login-Card">
        <div class="screen-1">

            <h2 class="title">Welcome Back</h2>

            <div class="input-group">
                <ion-icon name="mail-outline"></ion-icon>
                <input autocomplete="off" required type="email" name="email" placeholder="Email Address">
            </div>

            <div class="input-group password-group">
                <ion-icon name="lock-closed-outline"></ion-icon>
                <input required id="password" type="password" name="password" placeholder="Password">
                <ion-icon id="togglePassword" class="toggle" name="eye-outline"></ion-icon>
            </div>

            <div class="rememberme">
                <label>
                    <input type="checkbox" name="RememberMe" value="1">
                    Remember Me
                </label>
                <a href="#" class="forgot">Forgot Password?</a>
            </div>

            <button type="submit" name="logInBtn" class="login">Login</button>

            <div class="footer">
                <p>Don't have an account? <a href="SignUp.php">Sign Up</a></p>
            </div>

        </div>
    </div>
</form>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/IA/pages/Layout/Footer.php') ?>
</body>
</html>