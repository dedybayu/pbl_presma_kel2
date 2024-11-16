<?php
include "../config/database.php";
include "../fungsi/anti_injection.php";

// Mendapatkan data dari form atau input
// $username = $_POST['username'];
// $password = $_POST['password'];
// $level = $_POST['level'];  // Misalnya 'admin' atau 'user'

$username = "ines";
$password = "ines";
$level = "admin";

// Membuat koneksi ke database
$db = new Database();
$koneksi = $db->conn;

// Memanggil fungsi tambahUser untuk menambahkan user baru
$message = tambahUser($username, $password, $level, $koneksi);

// Menampilkan pesan
echo $message;



function tambahUser($username, $password, $level, $koneksi) {
    // Mengamankan input
    $username = antiinjection($username);
    $password = antiinjection($password);
    $level = antiinjection($level);

    // Membuat salt acak
    $salt = bin2hex(random_bytes(16));

    // Menggabungkan password dengan salt
    $combined_password = $salt . $password;

    // Mengenkripsi password menggunakan bcrypt
    $hashed_password = password_hash($combined_password, PASSWORD_BCRYPT);

    // Query untuk memasukkan data ke dalam tabel admin
    $query = "INSERT INTO [admin] (username, password, salt, level) VALUES (?, ?, ?, ?)";
    $params = array($username, $hashed_password, $salt, $level);
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
