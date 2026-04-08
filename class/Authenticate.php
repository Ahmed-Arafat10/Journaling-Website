<?php

namespace App;

class Authenticate
{
    public function signUp()
    {
        if (isset($_POST['signUpBtn'])) {
            //var_dump($_POST, $_SERVER['REQUEST_METHOD']);
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $confirmPassword = $_POST['confirm_password'];
            // string integer string integer integer string
            // sisiis
            if ($password != $confirmPassword) {
                \App\Alert::printMessage("Password is not matched", "danger");
            } else {
                $db = new DB();
                $insertQuery = "INSERT INTO `user` VALUES(NULL,?,?,?)";
                $prepareStmt = $db->connection->prepare($insertQuery);
                $prepareStmt->bind_param('sss', $username, $email, $hashedPassword);
                $checkQuery = $prepareStmt->execute();
                if ($checkQuery) {
                    header("Location: SignIn.php?signUpFinished=1");
                   // \App\Alert::printMessage("Sign Up Success", "success");
                } else {
                    \App\Alert::printMessage("Sign Up Failed", "danger");
                }
            }
        }
    }

    public function signIn()
    {
    }

    public function signOut()
    {
    }
}