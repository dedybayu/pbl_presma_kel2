<?php
session_start(); // Pastikan session dimulai

// Koneksi ke database
include '../model/PrestasiModel.php';
include "anti_injection.php";

$prestasi = new PrestasiModel();
$status = $prestasi->hapusPrestasi($_POST['prestasiId']);

if ($status === true) {
    $_SESSION['success_message'] = "Prestasi berhasil dihapus.";
    header("Location: ../index.php?page=daftarprestasi");
} else {
    $_SESSION['error_message'] = "Gagal menghapus prestasi.";
    header("Location: ../index.php?page=daftarprestasi");
}

// hapusPrestasi( $_POST['prestasiId']);

// function hapusPrestasi($koneksi, $id_prestasi) {
//     $id_prestasi = antiinjection($id_prestasi);
//     $query = "DELETE FROM prestasi WHERE id = ?";
//     $params = [$id_prestasi];
//     $stmt = sqlsrv_query($koneksi,$query, $params);
//     if ($stmt === false) {
//         // Set flash message
//         $_SESSION['error_message'] = "Gagal menghapus prestasi.";
//     } else {
//         $_SESSION['success_message'] = "Prestasi berhasil dihapus.";
//     }
//     header("Location: ../index.php?page=daftarprestasi");
//     exit();
// }
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['prestasiId'])) {
//     // Query untuk menghapus prestasi
//     $query = "DELETE FROM prestasi WHERE id = ?";
//     $params = [$_POST['prestasiId']];
//     // $stmt->bind_param("i", $prestasiId);
    
//     if ($stmt === false) {
//         // Set flash message
//         $_SESSION['success_message'] = "Prestasi berhasil dihapus.";
//     } else {
//         $_SESSION['error_message'] = "Gagal menghapus prestasi.";
//     }

//     // Redirect kembali ke halaman sebelumnya
//     header("Location: daftar_prestasi.php");
//     exit();
// }
