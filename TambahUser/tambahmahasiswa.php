<?php
include "../config/database.php";
include "../fungsi/anti_injection.php";

// Mendapatkan data dari form atau input
// $username = $_POST['username'];
// $password = $_POST['password'];
// $level = $_POST['level'];  // Misalnya 'admin' atau 'user'
// Mendapatkan data dari form atau input
$password = "2222222222";
$nim = "2222222222";
$nama = "Dedy Bayu";
$jenis_kelamin = "perempuan";
$id_prodi = "1";

// Membuat koneksi ke database
$db = new Database();
$koneksi = $db->conn;

// Memanggil fungsi tambahUser untuk menambahkan user baru
$message = tambahUser($koneksi, $nim, $password, $nama, $id_prodi, $jenis_kelamin);

// Menampilkan pesan
echo $message;

function tambahUser($koneksi, $nim, $password, $nama, $id_prodi, $jenis_kelamin) {
    // Mengamankan input
    $nim = antiinjection($nim);
    $password = antiinjection($password);
    $nama = antiinjection($nama);
    $id_prodi = antiinjection($id_prodi);
    $jenis_kelamin = antiinjection($jenis_kelamin);

    // Membuat salt acak
    $salt = bin2hex(random_bytes(16));

    // Menggabungkan password dengan salt
    $combined_password = $salt . $password;

    // Mengenkripsi password menggunakan bcrypt
    $hashed_password = password_hash($combined_password, PASSWORD_BCRYPT);

    // Query untuk memasukkan data ke dalam tabel mahasiswa
    $query = "INSERT INTO [mahasiswa] (NIM, password, salt, nama, id_prodi, jenis_kelamin) VALUES (?, ?, ?, ?, ?, ?)";
    $params = array($nim, $hashed_password, $salt, $nama, $id_prodi, $jenis_kelamin);
    $stmt = sqlsrv_query($koneksi, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($koneksi);

    // Mengembalikan pesan sukses
    return "User baru telah ditambahkan";
}
?>