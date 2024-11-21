<?php
require_once '../config/database.php'; // Memasukkan konfigurasi database

class Prestasi {
    private $db;
    
    public function __construct() {
        // Koneksi ke database
        $this->db = new Database();
    }

    public function savePrestasi($data, $files) {
        try {
            // Ambil data dari parameter $data dan $files
            $nim = $data['nim'];
            $nama_lomba = $data['nama_lomba'];
            $tingkat_lomba = $data['tingkat_lomba'];
            $juara_lomba = $data['juara_lomba'];
            $jenis_lomba = $data['jenis_lomba'];
            $penyelenggara_lomba = $data['penyelenggara_lomba'];
            $dosbim = $data['dosbim'];
            $tempat_lomba = $data['tempat_lomba'];
            $waktu_lomba = $data['waktu_lomba'];

            // Proses upload file (sertifikat, foto, dll)
            $file_sertifikat = $this->processFile($files['sertifikat']);
            $file_bukti_foto = $this->processFile($files['foto_lomba']);
            $file_surat_undangan = $this->processFile($files['suratUndangan']);
            $file_surat_tugas = $this->processFile($files['suratTugas']);
            $file_proposal = $this->processFile($files['proposal']);

            // Menghitung poin berdasarkan juara
            $poin = $this->calculatePoin($juara_lomba);

            // Tanggal upload
            $upload_date = date('Y-m-d');

            // Query SQL untuk insert data ke tabel prestasi
            $sql = "INSERT INTO prestasi (
                    NIM, nama_lomba, nip_dosbim, jenis_lomba, juara_lomba, tingkat_lomba, 
                    waktu_pelaksanaan, tempat_pelaksanaan, penyelenggara_lomba, 
                    file_bukti_foto, nama_file_bukti_foto, file_sertifikat, nama_file_sertifikat,
                    file_surat_undangan, nama_file_surat_undangan, file_surat_tugas, 
                    nama_file_surat_tugas, file_proposal, nama_file_proposal, poin, upload_date
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, 
                    ?, ?, ?, 
                    CONVERT(VARBINARY(MAX), ?), ?, CONVERT(VARBINARY(MAX), ?), ?, 
                    CONVERT(VARBINARY(MAX), ?), ?, CONVERT(VARBINARY(MAX), ?), ?, 
                    CONVERT(VARBINARY(MAX), ?), ?, ?, ?
                )";

            $params = [
                $nim,
                $nama_lomba,
                $dosbim,
                $jenis_lomba,
                $juara_lomba,
                $tingkat_lomba,
                $waktu_lomba,
                $tempat_lomba,
                $penyelenggara_lomba,
                $file_bukti_foto['content'],
                $file_bukti_foto['name'],
                $file_sertifikat['content'],
                $file_sertifikat['name'],
                $file_surat_undangan['content'],
                $file_surat_undangan['name'],
                $file_surat_tugas['content'],
                $file_surat_tugas['name'],
                $file_proposal['content'],
                $file_proposal['name'],
                $poin,
                $upload_date
            ];

            // Eksekusi query
            $stmt = sqlsrv_query($this->db->conn, $sql, $params);

            if ($stmt === false) {
                throw new Exception("Gagal menyimpan data: " . print_r(sqlsrv_errors(), true));
            }

            return true;
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    private function processFile($file) {
        if (empty($file['name'])) {
            return ['content' => NULL, 'name' => NULL];
        }

        if ($file['size'] > 1 * 1024 * 1024) {
            throw new Exception("Ukuran file terlalu besar. Maksimal 1 MB.");
        }

        return [
            'content' => file_get_contents($file['tmp_name']),
            'name' => $file['name']
        ];
    }

    private function calculatePoin($juara_lomba) {
        if ($juara_lomba == '1') {
            return 10;
        } elseif ($juara_lomba == '2') {
            return 7;
        } elseif ($juara_lomba == '3') {
            return 5;
        } else {
            return 3;
        }
    }
}
?>
