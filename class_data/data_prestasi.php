<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Memastikan sesi sudah dimulai
}

class ListPrestasi
{
    private $db;

    public function __construct()
    {
        $this->db = new Database(); // Menyimpan instance Database ke properti $db
    }

    public function getListPrestasi($nim)
    {
        $query = "SELECT * FROM prestasi WHERE NIM = $nim";
        $stmt = sqlsrv_query($this->db->conn, $query);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $listPrestasi = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $listPrestasi[] = $row; // Menambahkan setiap baris data ke array
        }
        sqlsrv_free_stmt($stmt);

        return $listPrestasi; // Mengembalikan array dosen
    }
}

?>