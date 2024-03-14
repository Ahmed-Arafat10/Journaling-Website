<?php

namespace App;

class Html
{
    public static function getScripts()
    {
        echo "<!-- Core -->";
        echo "<script src=\"assets/js/jquery.min.js\"></script>";
        echo " <script src=\"assets/js/bootstrap.min.js\"></script>";
    }
}