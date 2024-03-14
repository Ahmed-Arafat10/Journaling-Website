<?php

namespace App;

class Alert
{
    public static function PrintMessage($text, $Type)
    {
        if ($Type == "Danger") echo "<div style='text-align:center;margin-bottom:0;' class = 'alert alert-danger' role = 'alert' >" . $text . "</div>";
        else echo "<div style='text-align:center;margin-bottom:0;' class = 'alert alert-primary' role = 'alert' >" . $text . "</div>";
    }

    public static function alertAfterSignUp()
    {
        // When User Sign Up For First Time And After Redirecting From Sig up Page To Login Page (this Page), an Alert Will Be Shown
        if (isset($_GET['doneRegister'])) {
            Alert::PrintMessage("Done Creating Account", "Normal");
        }
    }

    public static function alertAfterSignIn()
    {
        //After User Login In Login Page And Redirected To This Page This Will Print Welcome Alert
        if (isset($_GET['DoneLogIn'])) {
            PrintMessage("Welcome Back," . $_SESSION['username'], "Normal");
            //echo $_COOKIE['RememberMe'];
        }
    }
}