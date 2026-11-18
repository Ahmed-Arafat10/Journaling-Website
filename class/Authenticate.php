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
            // Prepare Statement & Bind parameter
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
        if (!isset($_POST['signInBtn'])) {
            return;
        }
        // SELECT * from `user` where email = ?
        // 1 record exists -> email is correct -> then check the password
        // 0 records doesn't exist -> email is incorrect
        $email = $_POST['email'];
        $password = $_POST['password'];
        $myDB = new DB();
        $selectQuery = "SELECT * FROM `user` WHERE email = ?;";
        $stmtObj = $myDB->connection->prepare($selectQuery);
        $stmtObj->bind_param('s', $email);
        $check = $stmtObj->execute();
        if (!$check) {
            Alert::printMessage("Sign in failed please try again", "danger");
        }
        $resObj = $stmtObj->get_result();// mysqli_result   fetching   result set (rows/records)
        //var_dump($resObj);
        if ($resObj->num_rows == 0) {
            Alert::printMessage("email is incorrect", "danger");
            return;
        }
        $myRecord = $resObj->fetch_assoc();
        if (!password_verify($password, $myRecord['password'])) {
            Alert::printMessage("Password is incorrect", "danger");
            return;
        }
        $_SESSION['User_ID'] = $myRecord['id'];
        $_SESSION['username'] = $myRecord['name'];
        header('location: index.php');
    }

    public function logOut()
    {
        // ?val=1&val2=2
        if (isset($_GET['logOut'])) {
            session_destroy();
            header('location: SignIn.php');
        }
    }

    public function checkAuth()
    {
        return isset($_SESSION['User_ID']); // true / false
    }

    public function redirectIfAuth()
    {
        if ($this->checkAuth()) {
            header('location: index.php');
        }
    }

    public function redirectIfNotAuth()
    {
        if (!$this->checkAuth()) {
            header('location: signIn.php');
        }
    }
}