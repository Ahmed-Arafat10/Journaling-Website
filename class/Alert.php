<?php

namespace App;

class Alert
{
    public static function printMessage($message, $type)
    {
        if($type == 'success'){
            echo "<div style='text-align:center;margin-bottom:0;' class = 'alert alert-success' role = 'alert' >" . $message . "</div>";
        }else{
            echo "<div style='text-align:center;margin-bottom:0;' class = 'alert alert-danger' role = 'alert' >" . $message . "</div>";
        }
    }
}