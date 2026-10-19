<?php

namespace app;

use mysqli;

class DB
{
    private $hostname = 'localhost';
    private $username = 'root';
    private $databaseName = 'ia_sections_hu';
    private $password = '';
    public $connection;

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