<?php
require_once '../controller/PrestasiController.php';
include "../fungsi/anti_injection.php";

session_start();
$prestasiModel = new PrestasiModel();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['action'] === 'add' || $_POST['action'] === 'update') {
        // Terapkan antiinjection pada data POST
        $nim = antiinjection($_POST['nim']);
        $nama_lomba = antiinjection($_POST['nama_lomba']);
        $tingkat_lomba = antiinjection($_POST['tingkat_lomba']);
        $juara_lomba = antiinjection($_POST['juara_lomba']);
        $jenis_lomba = antiinjection($_POST['jenis_lomba']);
        $penyelenggara_lomba = antiinjection($_POST['penyelenggara_lomba']);
        $dosbim = antiinjection($_POST['dosbim']);
        $tempat_lomba = antiinjection($_POST['tempat_lomba']);
        $waktu_lomba = antiinjection($_POST['waktu_lomba']);
        $FILES = antiinjection_files($_FILES);

        if ($_POST['action'] === 'add') {
            $controller = new PrestasiController();

            $data = [
                'nim' => $nim,
                'nama_lomba' => $nama_lomba,
                'tingkat_lomba' => $tingkat_lomba,
                'juara_lomba' => $juara_lomba,
                'jenis_lomba' => $jenis_lomba,
                'penyelenggara_lomba' => $penyelenggara_lomba,
                'dosbim' => $dosbim,
                'tempat_lomba' => $tempat_lomba,
                'waktu_lomba' => $waktu_lomba
            ];

            $controller->addPrestasi($data, $FILES);
        }

        else if ($_POST['action'] === 'update') {
            $id = antiinjection($_POST['idPrestasi']);
            $controller = new PrestasiController();

            $data = [
                'nim' => $nim,
                'nama_lomba' => $nama_lomba,
                'tingkat_lomba' => $tingkat_lomba,
                'juara_lomba' => $juara_lomba,
                'jenis_lomba' => $jenis_lomba,
                'penyelenggara_lomba' => $penyelenggara_lomba,
                'dosbim' => $dosbim,
                'tempat_lomba' => $tempat_lomba,
                'waktu_lomba' => $waktu_lomba
            ];

            $controller->updatePrestasi($id, $data, $_FILES);
        }
    }

    if ($_POST['action'] === 'delete'){
        $status = $prestasiModel->hapusPrestasi($_POST['prestasiId']);

        if ($status === true) {
            $_SESSION['success_message'] = "Prestasi berhasil dihapus.";
        } else {
            $_SESSION['error_message'] = "Gagal menghapus prestasi.";
        }
        header("Location: ../index.php?page=daftarprestasi");
    }
}
?>