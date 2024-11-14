<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
$query = "SELECT username, level, salt, password AS hashed_password FROM [user] WHERE username = ?";
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
                header("Location: home.php");
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
