<?php 
// if (session_status() === PHP_SESSION_NONE) {
//     session_start(); // Memastikan sesi sudah dimulai
// }

// // Periksa apakah pengguna sudah login
// if (!empty($_SESSION['username'])) {
//     require_once 'config/database.php'; // Pastikan database.php dimuat hanya sekali
//     require_once 'fungsi/pesan_kilat.php'; // Pastikan pesan kilat dimuat hanya sekali

//     // include 'admin/template/header.php'; // Memuat header

//     // Validasi dan sanitasi halaman yang diminta
//     $page = !empty($_GET['page']) ? basename($_GET['page']) : null;
//     $modulePath = 'admin/module/' . $page . '/index.php';

//     // Periksa apakah file module ada
//     if ($page && file_exists($modulePath)) {
//         include $modulePath; // Muat halaman yang diminta
//     } elseif (!$page) {
//         include 'admin/dashboard/'; // Muat halaman beranda jika page kosong
//     } else {
//         // Tampilkan pesan error jika file tidak ditemukan
//         echo "<div class='container mt-5'>
//                 <div class='alert alert-danger text-center'>
//                     <strong>Halaman tidak ditemukan!</strong> Halaman yang Anda minta tidak tersedia.
//                 </div>
//               </div>";
//     }

//     include 'admin/template/footer.php'; // Memuat footer
// } else {
//     // Arahkan ke halaman login jika belum login
//     header("Location: login.php");
//     exit();
// }



if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Memastikan sesi sudah dimulai
}

// Periksa apakah pengguna sudah login
if (!empty($_SESSION['username'])) {
    // Arahkan ke dashboard jika sudah login
    header("Location: dashboard/");
    exit();
} else {
    // Arahkan ke halaman login jika belum login
    header("Location: login.php");
    exit();
}

?>
