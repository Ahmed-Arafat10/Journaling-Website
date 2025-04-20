<?php

namespace App;

class Authenticate
{
    public function isAuth()
    {
        return isset($_SESSION['userID']); // bool
    }

    public function redirectIfNotAuth()
    {
        if (!$this->isAuth())
            header('location: SignIn.php');
    }

    public function redirectIfAuth()
    {
        // Used in page SignIn & SignUp
        if ($this->isAuth())
            header('location: index.php');
    }

    public function signUp()
    {
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

    public function signIn()
    {
        if (isset($_POST['logInBtn'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            // myDBObject -> DB
            // Connection -> mysqli
            // queryStmtObject -> mysqli_stmt
            // resultObject -> mysqli_result
            $myDBObject = new DB();
            $selectStatement = 'SELECT * FROM `user` WHERE email = ?';
            $queryStmtObject = $myDBObject->Connection->prepare($selectStatement);
            $queryStmtObject->bind_param('s', $email);
            $queryStatus = $queryStmtObject->execute();
            if (!$queryStatus)
                Alert::PrintMessage('Something went wrong', 'Danger');
            else {
                $resultObject = $queryStmtObject->get_result();
                //echo "<pre>";
                //var_dump($resultObject);
                if ($resultObject->num_rows == 1) {
                    $rowArr = $resultObject->fetch_assoc();
                    //var_dump($rowArr);
                    if (password_verify($password, $rowArr["password"])) {
                        // Authenticated
                        $_SESSION['userID'] = $rowArr["id"]; // userID => X
                        $_SESSION['userName'] = $rowArr["name"];
                        Alert::PrintMessage("Welcome Back, " . $rowArr['name'], 'Normal');
                    } else {
                        Alert::PrintMessage('Wrong password', 'Danger');
                    }
                } else {
                    Alert::PrintMessage('Email is not valid', 'Danger');
                }
            }
        }
    }

    public function logOut()
    {
        if (isset($_GET['logout'])) {
            session_unset();
            session_destroy();
            header("location: SignIn.php");
        }
    }
}