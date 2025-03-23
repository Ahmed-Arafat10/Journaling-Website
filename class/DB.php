<?php

namespace App;

use mysqli;
//  \SqlServer\DB ->  SQL SERVER
//  \MySql\DB ->    MYSQL
//  \MongoDB\DB ->    MongoDB

// User
// Client
class DB
{
    private string $hostname = "localhost";
    private string $username = "root";
    private string $password = "";
    private string $database = "ia_section_2025";
    public mysqli $Connection;

    public function __construct()
    {
        // hostname username password database
        $this->Connection = new mysqli($this->hostname, $this->username, $this->password, $this->database);
        // __init__ -> python -> constructor
        // self     $this
        // .        ->
    }

    public function checkConnection()
    {
        if ($this->Connection->connect_error == null)
            echo "Connected To Database";
        else
            echo "Not Connected To Database";
    }
}