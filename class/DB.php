<?php

namespace App;
use mysqli;

// Set Time Zone To Cairo
date_default_timezone_set('Africa/Cairo');



class DB
{
    private static string $username = "root"; //2
    // Connect To Database

    private static string $password = ""; //3
    private static string $host = "Localhost"; //1
    private static string $db_name = "journaling"; //4
    public static mysqli $Con;

    public static function connect()
    {
        self::$Con = mysqli_connect(self::$host, self::$username, self::$password, self::$db_name);
        self::$Con->set_charset("UTF8");
    }

    public static function check()
    {
        if (self::$Con) Alert::PrintMessage("Done Connecting To DB", "Normal");
        else Alert::PrintMessage("Done Connecting To DB", "Normal");
    }

}