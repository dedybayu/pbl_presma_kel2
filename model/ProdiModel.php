<?php
if (file_exists('../config/database.php')) {
    require_once '../config/database.php';
}

class ProdiModel{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->conn;
    }
    
    function getALLProdi()
    {
        $query = "SELECT * FROM prodi";

        $stmt = sqlsrv_query($this->db, $query);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $daftarProdi = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $daftarProdi[] = $row; // Menambahkan setiap baris data ke array
        }
        sqlsrv_free_stmt($stmt);

        return $daftarProdi;
    }
}