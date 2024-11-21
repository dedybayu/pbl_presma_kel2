<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Memastikan sesi sudah dimulai
}

class Profile
{
    private $db;

    public function __construct()
    {
        $this->db = new Database(); // Menyimpan instance Database ke properti $db
    }

    public function getProfile($key)
    {
        if ($_SESSION['level'] === 'mahasiswa') {
            $query = "SELECT * FROM mahasiswa WHERE NIM = ?";
            $params = array($key);
            $stmt = sqlsrv_query($this->db->conn, $query, $params);

            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            sqlsrv_free_stmt($stmt);

            return $row;

        } elseif ($_SESSION['level'] === 'dosen') {
            $query = "SELECT * FROM dosen WHERE nip = ?";
            $params = array($key);
            $stmt = sqlsrv_query($this->db->conn, $query, $params);

            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            sqlsrv_free_stmt($stmt);

            return $row;

        } elseif ($_SESSION['level'] === 'admin') {
            $query = "SELECT * FROM admin WHERE username = ?";
            $params = array($key);
            $stmt = sqlsrv_query($this->db->conn, $query, $params);

            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            sqlsrv_free_stmt($stmt);

            return $row;
        } else {
            return null;
        }

    }
}
?>