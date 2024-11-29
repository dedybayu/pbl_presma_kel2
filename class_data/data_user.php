<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Memastikan sesi sudah dimulai
}

class ListDosen
{
    private $db;

    public function __construct()
    {
        $this->db = new Database(); // Menyimpan instance Database ke properti $db
    }

    public function getListDosen()
    {
            $query = "SELECT * FROM dosen";
            $stmt = sqlsrv_query($this->db->conn, $query);

            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            $dosenList = [];
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $dosenList[] = $row; // Menambahkan setiap baris data ke array
            }
            sqlsrv_free_stmt($stmt);

            return $dosenList; // Mengembalikan array dosen
    }
}

?>