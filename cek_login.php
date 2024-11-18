<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set waktu maksimal sesi
ini_set('session.gc_maxlifetime', 1440); // 1440 detik = 24 menit
session_set_cookie_params(1440); // Durasi cookie sesi 24 menit

// Cek apakah sesi telah kedaluwarsa (lebih dari 24 menit tanpa aktivitas)
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > 1440) {
    // Hapus sesi dan redirect ke halaman login
    session_unset(); 
    session_destroy(); 
    header("Location: ../sesi_habis.php"); // Redirect ke halaman login
    exit();
}

// Update waktu aktivitas terakhir
$_SESSION['LAST_ACTIVITY'] = time();

// Melanjutkan kode yang ada
include "config/database.php";
include "fungsi/pesan_kilat.php";
include "fungsi/anti_injection.php";

// Membuat koneksi database
$db = new Database();
$koneksi = $db->conn;

// Mengamankan input menggunakan fungsi anti-injection
$username = antiinjection($_POST['username']);
$password = antiinjection($_POST["password"]);

// Menjalankan query untuk mengambil informasi pengguna berdasarkan username
$query = "SELECT username, level, salt, password AS hashed_password FROM [admin] WHERE username = ?";
$params = array($username);
$stmt = sqlsrv_query($koneksi, $query, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Mengambil hasil query
$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
sqlsrv_free_stmt($stmt);
sqlsrv_close($koneksi);

if ($row) {
    $salt = $row['salt'];
    $hashed_password = $row['hashed_password'];

    // Validasi password
    if ($salt !== null && $hashed_password !== null) {
        $combined_password = $salt . $password;

        if (password_verify($combined_password, $hashed_password)) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['level'] = $row['level'];
            
            if ($row['level'] == "admin") {
                header("Location: dashboard/");
            } else {
                header("Location: mhs.php");
            }
            exit();
        } else {
            set_flashdata('error', "Username atau Password salah!"); // Set flash message error
            header("Location: index.php");
            exit();
        }
    }
} else {
    set_flashdata('error', "Username atau Password salah!"); // Set flash message error
    header("Location: index.php");
    exit();
}
?>
