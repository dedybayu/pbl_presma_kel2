<?php
class Database {
    private $host = "DEDYBAYU_LAPTOP\\SQLEXPRESS";
    private $connectionOptions = array(
        "Database" => "pbl_presma",
        "Uid" => "",  
        "PWD" => ""
    );

    public $conn;

    public function __construct() {
        $this->conn = sqlsrv_connect($this->host, $this->connectionOptions);
        if ($this->conn === false) {
            die("Connection Failed: " . print_r(sqlsrv_errors(), true));
        }
    }
}

// $db = new Database();
?>
