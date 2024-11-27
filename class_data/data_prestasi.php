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
        $query = "SELECT 
                id,
                NIM,
                nama_lomba,
                nip_dosbim,
                jenis_lomba,
                juara_lomba,
                tingkat_lomba,
                FORMAT(waktu_pelaksanaan, 'dd MMMM yyyy', 'id-ID') AS waktu_pelaksanaan,
                tempat_pelaksanaan,
                penyelenggara_lomba,
                file_bukti_foto,
                file_sertifikat,
                file_surat_undangan,
                file_surat_tugas,
                file_proposal,
                poin,
                upload_date,
                status_verifikasi,
                message
                    FROM prestasi
                    WHERE NIM = $nim";
        $stmt = sqlsrv_query($this->db->conn, $query);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $listPrestasi = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $listPrestasi[] = $row; // Menambahkan setiap baris data ke array
        }
        sqlsrv_free_stmt($stmt);

        return $listPrestasi;
    }

    public function getPrestasiById($id)
    {
        $query = "SELECT * FROM prestasi WHERE id = $id";
        $stmt = sqlsrv_query($this->db->conn, $query);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $listPrestasi = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $listPrestasi[] = $row; // Menambahkan setiap baris data ke array
        }
        sqlsrv_free_stmt($stmt);

        return $listPrestasi;
    }
}

?>