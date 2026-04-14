<?php

namespace App;

class Authenticate
{
    public function isAuth(): bool
    {
        return isset($_SESSION['userID']);// true / false
    }

    public function redirectIfAuth()
    {
        if ($this->isAuth()) header('Location: index.php');
    }

    public function redirectIfNotAuth()
    {
        if (!$this->isAuth()) header('Location: SignIn.php');
    }

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
                    $_SESSION['signUpSuccess'] = 1;
                    header("Location: SignIn.php");
                } else {
                    \App\Alert::printMessage("Sign Up Failed", "danger");
                }
            }
        }
    }

    public function signIn(): void
    {
        if (isset($_POST['logInBtn'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $db = new DB();
            $selectQuery = "SELECT * FROM `user` WHERE email = ?";
            $prepareStmtObj = $db->connection->prepare($selectQuery);
            $prepareStmtObj->bind_param('s', $email);
            $checkQuery = $prepareStmtObj->execute();
            if (!$checkQuery) {
                \App\Alert::printMessage("Something went wrong", "danger");
                return;
            }
            $resultObj = $prepareStmtObj->get_result();
            if ($resultObj->num_rows == 0) {
                \App\Alert::printMessage("Email not found", "danger");
                return;
            }
            $rowArr = $resultObj->fetch_assoc();
            $dbHashedPassword = $rowArr['password'];
            if (!password_verify($password, $dbHashedPassword)) {
                \App\Alert::printMessage("Wrong password", "danger");
                return;
            }
            $name = $rowArr['name'];
            $_SESSION['userID'] = $rowArr['id'];
            $_SESSION['userName'] = $name;
            header('Location: index.php');
            // Alert::printMessage("Welcome Back, $name", "success");
        }
    }

    public function signOut()
    {
        if (isset($_GET['logout'])) {
            session_unset();
            session_destroy();
            header('Location: SignIn.php');
        }
    }
}