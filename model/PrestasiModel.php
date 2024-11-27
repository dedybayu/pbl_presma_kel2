<?php
if (file_exists('../config/database.php')) {
    require_once '../config/database.php';
} else {
    // die("File database.php tidak ditemukan.");
}

class PrestasiModel
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->conn;
    }

    public function insertPrestasi($data)
    {
        $sql = "INSERT INTO prestasi (
                    NIM, nama_lomba, nip_dosbim, jenis_lomba, juara_lomba, tingkat_lomba, 
                    waktu_pelaksanaan, tempat_pelaksanaan, penyelenggara_lomba, 
                    file_bukti_foto, file_sertifikat,
                    file_surat_undangan, file_surat_tugas, 
                    file_proposal, poin, upload_date
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                    CONVERT(VARBINARY(MAX), ?), CONVERT(VARBINARY(MAX), ?), 
                    CONVERT(VARBINARY(MAX), ?), CONVERT(VARBINARY(MAX), ?), 
                    CONVERT(VARBINARY(MAX), ?), ?, ?
                )";

        $stmt = sqlsrv_prepare($this->db, $sql, $data);

        if (!$stmt) {
            throw new Exception("Gagal mempersiapkan query: " . print_r(sqlsrv_errors(), true));
        }

        if (!sqlsrv_execute($stmt)) {
            throw new Exception("Gagal mengeksekusi query: " . print_r(sqlsrv_errors(), true));
        }
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
        $stmt = sqlsrv_query($this->db, $query);

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
        $stmt = sqlsrv_query($this->db, $query);

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

    function hapusPrestasi($id_prestasi) {
        $id_prestasi = antiinjection($id_prestasi);
        $query = "DELETE FROM prestasi WHERE id = ?";
        $params = [$id_prestasi];
        $stmt = sqlsrv_query($this->db,$query, $params);
        if ($stmt === false) {
            // Set flash message
            $_SESSION['error_message'] = "Gagal menghapus prestasi.";
        } else {
            $_SESSION['success_message'] = "Prestasi berhasil dihapus.";
        }
        header("Location: ../index.php?page=daftarprestasi");
        exit();
    }
}
