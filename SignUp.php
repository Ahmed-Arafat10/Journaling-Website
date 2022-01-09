<?php
include("ConfigDB.php");

//When User Click On Sign Up Button, will save Data In Database 
if (isset($_POST['SignUpBTN'])) {
    $Username = mysqli_real_escape_string($DB, $_POST['Username']);
    $Password =  mysqli_real_escape_string($DB, $_POST['Password']);
    $ConfirmPassword =  mysqli_real_escape_string($DB, $_POST['ConfirmPassword']);
    $Email =  mysqli_real_escape_string($DB, $_POST['Email']);
    //If Pssword is not equal to Confirm Password
    if ($Password != $ConfirmPassword) {
        PrintMessage("Password Is Not Matched", "Danger");
    } 
    // Else means everything is fine
    else {
        $InsertQuery = " INSERT INTO `user` VALUES(NULL,'$Username','$Password','$Email')";
        $ExecuteAboveQuery = mysqli_query($DB, $InsertQuery);
        if ($ExecuteAboveQuery) {
            header("location:Login.php?DoneRegist=1");
        }
        //If Insert Query Is Not Excuted or if an error just happend 
        else
        {
            PrintMessage("Error While Signing In, Please Try Again", "Danger");
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <!-- Div That Contains Form Of Sigining Up Start -->
    <div class="row justify-content-center align-items-center h-100">
        <form method="POST">
            <div class="row">
                <div class="col">
                    <label for="inputEmail4">Username</label>
                    <input type="text" name="Username" class="form-control" placeholder="Please Enter Your Name">
                </div>
            </div>
            <div class="row">
                <div class="col ">
                    <label for="inputEmail4">Email</label>
                    <input type="email" name="Email" class="form-control" placeholder="Please Confirm Your Email">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="inputEmail4">Password</label>
                    <input type="password" name="Password" class="form-control" placeholder="Please Enter Your Password">
                </div>
                <div class="col">
                    <label for="inputEmail4">Confirm Password</label>
                    <input type="password" name="ConfirmPassword" class="form-control" placeholder="Please Confirm Password">
                </div>
            </div>
            <button type="submit" name="SignUpBTN" class="btn btn-outline-primary text-center col-md">Sign In</button>
        </form>
    </div>
    <!-- Div That Contains Form Of Sigining Up End -->

</body>

</html>