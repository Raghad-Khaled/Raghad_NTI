<?php
namespace App\Database\Connection;


class Connection {
    private string $dbName = 'nti_project';
    private string $hostName = 'localhost';
    private string $username = 'root';
    private string $password = '';
    private int $DBport = 3306; 
    protected \mysqli $conn;

    public function __construct() {
        $this->conn = new \mysqli($this->hostName,$this->username,$this->password,
        $this->dbName,$this->DBport);
        // if ($conn->connect_error) {
        //     die("Connection failed: " . $conn->connect_error);
        // }
        // echo "Connected successfully";
    }
}

new Connection;