<?php

namespace App;

use mysqli;

class DB
{
    private string $dbName = 'ia_section_journaling';
    private string $password = '';
    private string $userName = 'root';
    private string $host = 'localhost';
    public mysqli $Con;

    public function connect()
    {
        $this->Con = mysqli_connect($this->host, $this->userName, $this->password, $this->dbName);
    }
    public function check(){
        if(!$this->Con) echo "Failed";
        else echo "Done";
    }

}