<?php

namespace App;

/*
Alert::printMessage("Hello World", "success");
*/

class Alert
{
    public static function printMessage($text, $type)
    {
        //  primary/secondary/success/danger/warning/info/light/dark
        echo "<div style='text-align:center;margin-bottom:0;' class = 'alert alert-" . $type . "' role = 'alert' >" . $text . "</div>";
    }

    public function showSuccessSignUpAlert()
    {
        # Bad Way
        // if (isset($_GET['signUpFinished'])) {
        //\App\Alert::printMessage("Sign Up Success", "success");
        //unset($_GET['signUpFinished']);
        // }
        if (isset($_SESSION['signUpSuccess'])) {
            \App\Alert::printMessage("Sign Up Success", "success");
            unset($_SESSION['signUpSuccess']);
        }
    }
}