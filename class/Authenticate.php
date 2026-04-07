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
            $password = $_POST['password']; // Plain text
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $confirmPassword = $_POST['confirm_password'];
            if ($password != $confirmPassword) {
                Alert::PrintMessage('Passwords do not match', 'Danger');
            } else {
                $DB = new DB();
                $insertQuery = "INSERT INTO `user` VALUES (NULL,?,?,?)";
                $prepareStmtObj = $DB->connection->prepare($insertQuery);
                $prepareStmtObj->bind_param('sss', $username, $email, $hashedPassword);
                $check = $prepareStmtObj->execute();
                if ($check) {
                    //Alert::PrintMessage('User created successfully', 'Success');
                    header('Location: SignIn.php');
                } else {
                    Alert::PrintMessage('Something went wrong', 'Danger');
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