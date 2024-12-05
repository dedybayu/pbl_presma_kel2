<?php
include "../config/database.php";
include "../fungsi/anti_injection.php";

// Mendapatkan data dari form atau input
// $username = $_POST['username'];
// $password = $_POST['password'];
// $level = $_POST['level'];  // Misalnya 'admin' atau 'user'

$password = "dosen";
$nip = "00000";
$nama = "Budi";
$jenis_kelamin = "laki-laki";
// Membuat koneksi ke database
$db = new Database();
$koneksi = $db->conn;

// Memanggil fungsi tambahUser untuk menambahkan user baru
$message = tambahUser($koneksi, $nip, $password, $nama, $jenis_kelamin);

// Menampilkan pesan
echo $message;



function tambahUser($koneksi, $nip, $password, $nama, $jenis_kelamin) {
    // Mengamankan input
    $nip = antiinjection($nip);
    $password = antiinjection($password);
    $nama = antiinjection($nama);
    $jenis_kelamin = antiinjection($jenis_kelamin);

    // Membuat salt acak
    $salt = bin2hex(random_bytes(16));

    // Menggabungkan password dengan salt
    $combined_password = $salt . $password;

    // Mengenkripsi password menggunakan bcrypt
    $hashed_password = password_hash($combined_password, PASSWORD_BCRYPT);

    // Query untuk memasukkan data ke dalam tabel admin
    $query = "INSERT INTO [dosen] (nip, password, salt, nama, jenis_kelamin) VALUES (?, ?, ?, ?,?)";
    $params = array($nip, $hashed_password, $salt, $nama, $jenis_kelamin);
    $stmt = sqlsrv_query($koneksi, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
}

?>
