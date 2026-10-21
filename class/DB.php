<?php

namespace App;

use mysqli;

class DB
{
    private string $hostname = 'localhost';
    private string $username = 'root';
    private string $databaseName = 'ia_sections_hu';
    private string $password = '';
    public mysqli $connection;

    public function __construct()
    {
        $this->connection = new mysqli(
            $this->hostname,
            $this->username,
            $this->password,
            $this->databaseName
        );
    }
}