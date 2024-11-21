<?php
include "../config/database.php";
include "../fungsi/anti_injection.php";

// Mendapatkan data dari form atau input
// $username = $_POST['username'];
// $password = $_POST['password'];
// $level = $_POST['level'];  // Misalnya 'admin' atau 'user'

$password = "dosen";
$nip = "54321";
$nama = "Ines ";
$jabatan = "Dosen Kimia";

// Membuat koneksi ke database
$db = new Database();
$koneksi = $db->conn;

// Memanggil fungsi tambahUser untuk menambahkan user baru
$message = tambahUser($koneksi, $nip, $password, $nama, $jabatan);

// Menampilkan pesan
echo $message;



function tambahUser($koneksi, $nip, $password, $nama, $jabatan) {
    // Mengamankan input
    $nip = antiinjection($nip);
    $password = antiinjection($password);
    $nama = antiinjection($nama);
    $jabatan = antiinjection($jabatan);

    // Membuat salt acak
    $salt = bin2hex(random_bytes(16));

    // Menggabungkan password dengan salt
    $combined_password = $salt . $password;

    // Mengenkripsi password menggunakan bcrypt
    $hashed_password = password_hash($combined_password, PASSWORD_BCRYPT);

    // Query untuk memasukkan data ke dalam tabel admin
    $query = "INSERT INTO [dosen] (nip, password, salt, nama, jabatan) VALUES (?, ?, ?, ?, ?)";
    $params = array($nip, $hashed_password, $salt, $nama, $jabatan);
    $stmt = sqlsrv_query($koneksi, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($koneksi);

    // Mengembalikan pesan sukses
    return "User baru telah ditambahkan.";
}

?>
