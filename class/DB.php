<?php

namespace App;
// DB -> mysql
// DB -> oracle
// DB -> sql server
use mysqli;

class DB
{
    // Attributes
    private string $username = 'root';
    private string $host = 'localhost';
    private string $database = 'ia_sections_bis_2026_g1';
    private string $password = '';
    // Has-a Relationship
    public mysqli $connection;

    // Methods
    // constructor
    public function __construct()
    {
        // Python -> car = Car();
        // self -> $this
        // .    -> ->
        // Initiate a new object of class mysqli
        $this->connection = new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->database,
        );
    }

    public function check(): void
    {
        // connect_error is an attribute in class mysqli
        if ($this->connection->connect_error == null) {
            echo "Connected successfully";
        } else {
            echo "Connection failed";
        }
    }


}