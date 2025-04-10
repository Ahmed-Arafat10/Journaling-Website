<?php

namespace App;

class Authenticate
{
    public function signUp(){
        // signUpBtn => ''
        // alert
        // Validation
        // Plain Text      -> Cipher Text
        if (isset($_POST['signUpBtn'])) {
            //var_dump($_POST);
            $username = $_POST['username'];
            $email = $_POST['email']; //
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];
            if ($password != $confirmPassword)
                \App\Alert::PrintMessage("Confirm Password not matched", 'Danger');
            else {
                $myDatabaseObj = new \App\DB();
                $insertStatement = "INSERT INTO `user` VALUES(NULL,?,?,?)"; // Sql injection
                $queryObj = $myDatabaseObj->Connection->prepare($insertStatement);
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $queryObj->bind_param('sss', $username, $email, $hashedPassword);
                $queryStatus = $queryObj->execute();
                if ($queryStatus)
                    header('location: SignIn.php?doneSignUp=1');
                else
                    Alert::PrintMessage("Failed to create your account", 'Danger');
            }
        }
    }
}