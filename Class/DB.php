<?php

namespace app;

class DB
{
    private string $username = "root"; //2
    // Connect To Database

    private string $password = ""; //3
    private string $host = "Localhost"; //1
    private string $db_name = "journaling"; //4
    public $Con;

    public function connect()
    {
        $this->Con = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
        $this->Con->set_charset("UTF8");
    }

    public function check()
    {
        if ($this->Con) Alert::PrintMessage("Done Connecting To DB", "Normal");
        else Alert::PrintMessage("Done Connecting To DB", "Normal");
    }

}