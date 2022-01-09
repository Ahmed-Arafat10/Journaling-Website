<?php
include("ConfigDB.php");

//Debug
// echo "Login Page";

//When User Click On Sign in Button, will check if Data exist In Database or not 
if (isset($_POST['LogInBTN'])) {
    $UserName = $_POST['Username'];
    $Password = $_POST['Password'];
    $Check = "SELECT * FROM `user` WHERE Name = '$UserName' AND Password = '$Password' ";
    $ExecuteAboveStatement  = mysqli_query($DB, $Check);
    $NumOfRows = mysqli_num_rows($ExecuteAboveStatement);
    if ($NumOfRows == 1) {
        $_SESSION['User'] = $UserName;
        $FetchData = mysqli_fetch_array($ExecuteAboveStatement);
        $_SESSION['UserID'] = $FetchData['ID'];
        header('location:index.php?DoneLogIn=1');
    } else  PrintMessage("User Is Not Exist", "Danger");
}



// When user sign up for first time and after redircting from sigup page to login page (This Page), an alert will be shown
if (isset($_GET['DoneRegist'])) {
    PrintMessage("Done Creating Account", "Normal");
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap'>
</head>

<body>
    <!-- Div That Contains Form Of Sigining In Start -->
    <form method="POST">
        <div class="Login-Card">
            <div class="screen-1">
                <div class="email">
                    <label for="email">Username</label>
                    <div class="sec-2">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input required type="text" name="Username" placeholder="Example: Ahmed Arafat" />
                    </div>
                </div>
                <div class="password">
                    <label for="password">Password</label>
                    <div class="sec-2">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input required class="pas" type="password" name="Password" placeholder="············" />
                        <ion-icon class="show-hide" name="eye-outline"></ion-icon>
                    </div>
                </div>
                <button type="submit" Name="LogInBTN" class="login">Login</button>

                <div class="footer"><a href="SignUp.php">Signup</a><span>Forgot Password?</span></div>

            </div>
    </form>
    <!-- Div That Contains Form Of Sigining In End -->
</body>

</html>