<?php

namespace App;

class Authenticate
{
    public function signUp(): void
    {
        if (isset($_POST['signUpBtn'])) {
            //var_dump($_POST);
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];// 123
            $confirmPassword = $_POST['confirm_password']; // 1234
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            // validation
            if ($password != $confirmPassword) {
                // Class::StaticMethod()
                Alert::printMessage("Passwords do not match", "danger");
                return;
            }
            // Validation -> Correct
            $myDB = new DB();
            $insertQuery = "INSERT INTO `user` VALUES (NULL,?,?,?);";
            // Prepare Statement & Bind paramter
            $stmtObj = $myDB->connection->prepare($insertQuery); // mysqli_stmt
            // 1) syntax
            // 2) Semantic
            // 3) execution plan
            // 4) Execute
            // SQL injection
            $stmtObj->bind_param('sss', $username, $email, $hashedPassword);
            $checkQuery = $stmtObj->execute();
            if ($checkQuery) {
                Alert::printMessage("Sign up successful", "success");
            } else {
                Alert::printMessage("Sign up failed", "danger");
            }
        }
    }

    public function signIn()
    {

    }

    public function logOut()
    {

    }
}