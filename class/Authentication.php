<?php

namespace App;

class Authentication
{
    public static function auth()
    {
        //If user hasnt logged in this will force him to go to login page
        if (!isset($_SESSION['user_id']) && !isset($_COOKIE['rememberMe'])) {

            header('location:Login.php');
            exit;
        }
        if (isset($_COOKIE['RememberMe'])) $_SESSION['user_id'] = $_COOKIE['rememberMe'];
    }

    public static function IsUserLoggedIn()
    {
        if (isset($_SESSION['UserID']) || isset($_COOKIE['RememberMe'])) {
            if (isset($_COOKIE['RememberMe'])) $_SESSION['UserID'] = $_COOKIE['RememberMe'];
            header('location:index.php');
        }
    }

    public static function signUp()
    {
        ////When User Click On Sign Up Button, will save Data In Database
        $userName = null;
        $email = null;
        $password = null;
        $confirmPassword = null;
        if (isset($_POST['signUpBtn'])) {
            $userName = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];
            if ($password != $confirmPassword) {
                Alert::PrintMessage("Password Is Not Matched", "Danger");
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $insertQuery = "INSERT INTO `user` VALUES(NULL,?,?,?)";
                $Query = DB::$Con->prepare($insertQuery);
                $Query->bind_param('sss', $userName, $hashedPassword, $email);
                $check = $Query->execute();
                $Query->close();
                if ($check)
                    header("location:Login.php?doneRegister=1");
                else
                    Alert::PrintMessage("Error While Signing In, Please Try Again", "Danger");
            }
        }
        return [
            $userName, $email, $password, $confirmPassword
        ];
    }

    public static function logIn()
    {
        //When User Click On Sign in Button, will check if Data exist In Database or not
        if (isset($_POST['logInBtn'])) {
            $UserName = $_POST['Username'];
            $Password = $_POST['Password'];
            //$RememberMe = NULL;
            //if (isset($_POST['RememberMe'])) $RememberMe = $_POST['RememberMe'];
            // if (!empty($RememberMe)) $RememberMe = 1;
            // else $RememberMe = 0;
            $selectQuery = "SELECT * FROM `user` WHERE (`Name` = ? OR `Email` = ?)";
            $stmt = DB::$Con->prepare($selectQuery);
            $stmt->bind_param('ss', $UserName, $UserName);
            $check = $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows) {
                $Data = $result->fetch_assoc();
                if (password_verify($Password, $Data['Password'])) {
                    $_SESSION['user'] = $Data;
                    $_SESSION['username'] = $UserName;
                    // $FetchData = mysqli_fetch_array($ExecuteAboveStatement);
                    $_SESSION['user_id'] = $Data['ID'];
                    //if ($RememberMe) setcookie("RememberMe", $_SESSION['UserID'], time() + 2 * 24 * 60 * 60);
                header('location:index.php?DoneLogIn=1');
                } else  Alert::PrintMessage("Password Is Wrong", "Danger");
            } else {
                Alert::PrintMessage("Username Is Not Exist", "Danger");
            }
        }
    }
    public static function logOut()
    {
        //When user click on logout button, destroy $_Session array from memory & unset all key -> Value
        if (isset($_GET['logOut'])) {
            session_unset();
            session_destroy();
            //setcookie("RememberMe","",time() - 3600);
            header('location:index.php');
        }
    }
}