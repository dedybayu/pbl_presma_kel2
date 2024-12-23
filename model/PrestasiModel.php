<?php
if (file_exists('../config/database.php')) {
    require_once '../config/database.php';
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
                    NIM, nama_lomba, nip_dosbim, jenis_lomba, juara_lomba, status_tim, tingkat_lomba,
                    waktu_pelaksanaan, tempat_pelaksanaan, penyelenggara_lomba,
                    file_bukti_foto, file_sertifikat,
                    file_surat_undangan, file_surat_tugas,
                    file_proposal, poin, upload_date
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
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

    public function updatePrestasi($id_prestasi, $data)
    {
        // Query UPDATE untuk memperbarui data pada tabel `prestasi`
        $sql = "UPDATE prestasi
                SET
                    NIM = ?,
                    nama_lomba = ?,
                    nip_dosbim = ?,
                    jenis_lomba = ?,
                    juara_lomba = ?,
                    status_tim = ?,
                    tingkat_lomba = ?,
                    waktu_pelaksanaan = ?,
                    tempat_pelaksanaan = ?,
                    penyelenggara_lomba = ?,
                    file_bukti_foto = ISNULL(CONVERT(VARBINARY(MAX), ?), file_bukti_foto),
                    file_sertifikat = ISNULL(CONVERT(VARBINARY(MAX), ?), file_sertifikat),
                    file_surat_undangan = ISNULL(CONVERT(VARBINARY(MAX), ?), file_surat_undangan),
                    file_surat_tugas = ISNULL(CONVERT(VARBINARY(MAX), ?), file_surat_tugas),
                    file_proposal = ISNULL(CONVERT(VARBINARY(MAX), ?), file_proposal),
                    poin = ?,
                    upload_date = ?,
                    status_verifikasi = 'waiting'
                WHERE id = ?";

        // Parameter untuk query
        $params = [
            $data['nim'],
            $data['nama_lomba'],
            $data['dosbim'],
            $data['jenis_lomba'],
            $data['juara_lomba'],
            $data['status_tim'],
            $data['tingkat_lomba'],
            $data['waktu_lomba'],
            $data['tempat_lomba'],
            $data['penyelenggara_lomba'],
            $data['file_bukti_foto'], // File bukti foto (jika ada)
            $data['file_sertifikat'], // Sertifikat (jika ada)
            $data['file_surat_undangan'], // Surat undangan (jika ada)
            $data['file_surat_tugas'], // Surat tugas (jika ada)
            $data['file_proposal'], // Proposal (jika ada)
            $data['poin'],
            $data['upload_date'],
            $id_prestasi, // ID untuk menentukan baris yang akan diperbarui
        ];

        // Mempersiapkan query
        $stmt = sqlsrv_prepare($this->db, $sql, $params);

        // Cek apakah query berhasil dipersiapkan
        if (!$stmt) {
            throw new Exception("Gagal mempersiapkan query: " . print_r(sqlsrv_errors(), true));
        }

        // Eksekusi query
        if (!sqlsrv_execute($stmt)) {
            throw new Exception("Gagal mengeksekusi query: " . print_r(sqlsrv_errors(), true));
        }
    }

    public function getTopPrestasi($nim)
    {
        $query = "SELECT TOP 1 * FROM prestasi WHERE NIM = ? ORDER BY poin DESC;";
        $params = [$nim];
        $stmt = sqlsrv_query($this->db, $query, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $Prestasi = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        sqlsrv_free_stmt($stmt);

        return $Prestasi;
    }

    public function getTop3Prestasi(): array
    {
        $query = "SELECT TOP 3 p.*, m.nama
        FROM prestasi p
        INNER JOIN mahasiswa m ON p.NIM = m.NIM
        WHERE p.status_verifikasi = 'valid'
        ORDER BY p.poin DESC;";

        $stmt = sqlsrv_query($this->db, $query);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $Prestasi = [];

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $Prestasi[] = $row;
        }
        sqlsrv_free_stmt($stmt);

        return $Prestasi;
    }

    public function getTopAllPrestasi()
    {
        $query = "SELECT m.nama AS nama_mhs, p.nama_lomba, p.juara_lomba, p.tingkat_lomba, p.waktu_pelaksanaan, p.penyelenggara_lomba, p.poin, p.upload_date, p.status_verifikasi, p.file_sertifikat
         FROM prestasi p JOIN mahasiswa m ON p.NIM = m.NIM ORDER BY p.upload_date DESC;";

        $stmt = sqlsrv_query($this->db, $query);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $Prestasi = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        sqlsrv_free_stmt($stmt);

        return $Prestasi;
    }

    public function getAllPrestasi()
    {
        $query = "WITH TotalPoin AS (
            SELECT 
                NIM, 
                SUM(poin) AS total_poin
            FROM 
                prestasi
            WHERE 
                status_verifikasi = 'valid'
            GROUP BY 
                NIM
        ),
        RankedMahasiswa AS (
            SELECT 
                m.NIM, 
                m.nama AS nama_mhs, 
                tp.total_poin,
                RANK() OVER (ORDER BY tp.total_poin DESC) AS ranking
            FROM 
                mahasiswa m
            LEFT JOIN 
                TotalPoin tp 
            ON 
                m.NIM = tp.NIM
        )
        SELECT 
            m.nama AS nama_mhs, 
            p.id, 
            p.nama_lomba, 
            p.juara_lomba, 
            p.status_tim, 
            p.tingkat_lomba, 
            p.waktu_pelaksanaan, 
            p.penyelenggara_lomba, 
            p.poin, 
            p.upload_date, 
            p.status_verifikasi,
            tp.total_poin,
            rm.ranking
        FROM 
            prestasi p 
        JOIN 
            mahasiswa m 
        ON 
            p.NIM = m.NIM
        LEFT JOIN 
            TotalPoin tp 
        ON 
            m.NIM = tp.NIM
        LEFT JOIN 
            RankedMahasiswa rm 
        ON 
            m.NIM = rm.NIM
        ORDER BY 
            rm.ranking ASC;

        ";
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

    public function top3PrestasiByDosbim($nip)
    {
        $query = "SELECT TOP 3 p.*, m.nama AS nama_mhs
            FROM prestasi p
            JOIN mahasiswa m ON p.NIM = m.NIM
            WHERE nip_dosbim = ? AND status_verifikasi = 'valid'
            ORDER BY poin DESC;
            ";
        $params = [$nip];
        $stmt = sqlsrv_query($this->db, $query, $params);

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

    public function getPrestasiByNim($nim)
    {
        $query = "SELECT * FROM prestasi WHERE NIM = ?";
        $params = [$nim];
        $stmt = sqlsrv_query($this->db, $query, $params);

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
        $query = "SELECT p.*, m.nama AS nama_mhs FROM prestasi p JOIN mahasiswa m ON p.NIM = m.NIM WHERE p.id = $id";

        $stmt = sqlsrv_query($this->db, $query);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $Prestasi = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        sqlsrv_free_stmt($stmt);

        return $Prestasi;
    }

    public function getPrestasiByDosen($nip)
    {
        $query = "WITH TotalPoin AS (
            SELECT 
                NIM, 
                SUM(poin) AS total_poin
            FROM 
                prestasi
            WHERE 
                status_verifikasi = 'valid'
            GROUP BY 
                NIM
        ),
        RankedMahasiswa AS (
            SELECT 
                m.NIM, 
                m.nama AS nama_mhs, 
                tp.total_poin,
                RANK() OVER (ORDER BY tp.total_poin DESC) AS ranking
            FROM 
                mahasiswa m
            LEFT JOIN 
                TotalPoin tp 
            ON 
                m.NIM = tp.NIM
        )
        SELECT 
            m.nama AS nama_mhs, 
            p.id, 
            p.nama_lomba, 
            p.juara_lomba, 
            p.status_tim, 
            p.tingkat_lomba, 
            p.waktu_pelaksanaan, 
            p.penyelenggara_lomba, 
            p.poin, 
            p.upload_date, 
            p.status_verifikasi,
            tp.total_poin,
            rm.ranking
        FROM 
            prestasi p 
        JOIN 
            mahasiswa m 
        ON 
            p.NIM = m.NIM
        LEFT JOIN 
            TotalPoin tp 
        ON 
            m.NIM = tp.NIM
        LEFT JOIN 
            RankedMahasiswa rm 
        ON 
            m.NIM = rm.NIM
        WHERE 
            p.nip_dosbim = ? 
        ORDER BY 
            rm.ranking ASC;
        ";
        $params = array($nip);
        $stmt = sqlsrv_query($this->db, $query, $params);

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

    public function hapusPrestasi($id_prestasi)
    {
        $id_prestasi = antiinjection($id_prestasi);
        $query = "DELETE FROM prestasi WHERE id = ?";
        $params = [$id_prestasi];
        $stmt = sqlsrv_query($this->db, $query, $params);
        if ($stmt === false) {
            return false;
        } else {
            return true;
        }
    }

    public function updateValidasi($id_prestasi, $verifikasi, $message)
    {
        $query = "UPDATE prestasi SET status_verifikasi = ? WHERE id = ?";
        $params = array($verifikasi, $id_prestasi);
        $stmt = sqlsrv_query($this->db, $query, $params);
        if ($stmt === false) {
            return false;
        } else {
            $this->updateMessage($id_prestasi, $message);
            return true;
        }
    }

    public function updateMessage($id_prestasi, $message)
    {
        $query = "UPDATE prestasi SET message = ? WHERE id = ?";
        $params = array($message, $id_prestasi);
        $stmt = sqlsrv_query($this->db, $query, $params);
        if ($stmt === false) {
            return false;
        } else {
            return true;
        }
    }

}
