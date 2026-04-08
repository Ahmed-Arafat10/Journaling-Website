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
}