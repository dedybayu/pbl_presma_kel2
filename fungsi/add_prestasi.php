<?php
require_once '../config/database.php'; // Pastikan file ini sudah berisi konfigurasi koneksi database

$db = new Database(); // Pastikan class Database sudah benar dan koneksi dapat dilakukan

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Ambil data dari form
        $nim = $_POST['nim'];
        $nama_lomba = $_POST['nama_lomba'];
        $tingkat_lomba = $_POST['tingkat_lomba'];
        $juara_lomba = $_POST['juara_lomba'];
        $jenis_lomba = $_POST['jenis_lomba'];
        $penyelenggara_lomba = $_POST['penyelenggara_lomba'];
        $dosbim = $_POST['dosbim'];
        $tempat_lomba = $_POST['tempat_lomba'];
        $waktu_lomba = $_POST['waktu_lomba'];

        // Validasi file sertifikat
        if ($_FILES['sertifikat']['size'] > 1 * 1024 * 1024) {
            throw new Exception("Ukuran file sertifikat terlalu besar. Maksimal 1 MB.");
        }
        $file_sertifikat = file_get_contents($_FILES['sertifikat']['tmp_name']);

        // Validasi file bukti foto
        if ($_FILES['foto_lomba']['size'] > 1 * 1024 * 1024) {
            throw new Exception("Ukuran file bukti foto terlalu besar. Maksimal 1 MB.");
        }
        $file_bukti_foto = file_get_contents($_FILES['foto_lomba']['tmp_name']);

        // Validasi file surat undangan
        $file_surat_undangan = NULL;
        if (!empty($_FILES['suratUndangan']['name'])) {
            if ($_FILES['suratUndangan']['size'] > 1 * 1024 * 1024) {
                throw new Exception("Ukuran file surat undangan terlalu besar. Maksimal 1 MB.");
            }
            $file_surat_undangan = file_get_contents($_FILES['suratUndangan']['tmp_name']);
        }

        // Validasi file surat tugas
        $file_surat_tugas = NULL;
        if (!empty($_FILES['suratTugas']['name'])) {
            if ($_FILES['suratTugas']['size'] > 1 * 1024 * 1024) {
                throw new Exception("Ukuran file surat tugas terlalu besar. Maksimal 1 MB.");
            }
            $file_surat_tugas = file_get_contents($_FILES['suratTugas']['tmp_name']);
        }

        // Validasi file proposal
        $file_proposal = NULL;
        // $tmp_file_proposal = null;
        if (!empty($_FILES['proposal']['name'])) {
            if ($_FILES['proposal']['size'] > 1 * 1024 * 1024) {
                throw new Exception("Ukuran file proposal terlalu besar. Maksimal 1 MB.");
            }
            $file_proposal = file_get_contents($_FILES['proposal']['tmp_name']);
        }

        // Menghitung poin berdasarkan tingkat lomba dan juara
        $poin = 0;
        if ($tingkat_lomba == 'internasional') {
            if ($juara_lomba == '1') {
                $poin = 100;
            } elseif ($juara_lomba == '2') {
                $poin = 90;
            } elseif ($juara_lomba == '3') {
                $poin = 80;
            } else {
                $poin = 50;
            }
        } elseif ($tingkat_lomba == 'nasional') {
            if ($juara_lomba == '1') {
                $poin = 80;
            } elseif ($juara_lomba == '2') {
                $poin = 70;
            } elseif ($juara_lomba == '3') {
                $poin = 60;
            } else {
                $poin = 30;
            }
        } elseif ($tingkat_lomba == 'regional') {
            if ($juara_lomba == '1') {
                $poin = 60;
            } elseif ($juara_lomba == '2') {
                $poin = 50;
            } elseif ($juara_lomba == '3') {
                $poin = 40;
            } else {
                $poin = 10;
            }
        }

        // Tanggal upload
        $upload_date = date('Y-m-d');

        // Query SQL untuk insert data ke tabel prestasi
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
            $file_bukti_foto,
            $file_sertifikat,
            $file_surat_undangan,
            $file_surat_tugas,
            $file_proposal,
            $poin,
            $upload_date
        ];

        // Eksekusi query
        $stmt = sqlsrv_query($db->conn, $sql, $params);

        if ($stmt === false) {
            throw new Exception("Gagal menyimpan data: " . print_r(sqlsrv_errors(), true));
        }

        // echo "Data berhasil disimpan ke database!";
        header("Location: ../index.php?page=daftarprestasi");

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
