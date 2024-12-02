<?php
if (file_exists('../config/database.php')) {
    require_once '../config/database.php';
}

class MahasiswaModel
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->conn;
    }

    function getAllMahasiswa()
    {
        $query = "SELECT m.*, p.nama_prodi AS prodi FROM mahasiswa m JOIN prodi p ON m.id_prodi = p.id";
        // Mempersiapkan query
        $stmt = sqlsrv_query($this->db, $query);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $daftarMahasiswa = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $daftarMahasiswa[] = $row; // Menambahkan setiap baris data ke array
        }
        sqlsrv_free_stmt($stmt);

        return $daftarMahasiswa;
    }

    function updateBiodata($data){
        $query = "UPDATE mahasiswa SET nama = ?, email = ?, no_telp = ? WHERE NIM = ?";
        $stmt = sqlsrv_prepare($this->db, $query, $data);
    }

    function changePassword($data){
        return "aaa";
    }
    
}