<?php

namespace app;

class Alert
{
    public static function PrintMessage($text, $Type)
    {
        if ($Type == "Danger") echo "<div style='text-align:center;margin-bottom:0;' class = 'alert alert-danger' role = 'alert' >" . $text . "</div>";
        else echo "<div style='text-align:center;margin-bottom:0;' class = 'alert alert-primary' role = 'alert' >" . $text . "</div>";
    }
}