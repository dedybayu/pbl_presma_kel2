<?php
// Mulai session untuk memeriksa apakah pengguna sudah login
session_start();

// Cek apakah session 'username' ada (artinya pengguna sudah login)
if (!isset($_SESSION['nim'])) {
    // Jika session tidak ada, arahkan ke halaman login
    header("Location: blm.php");
    exit();
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Hallo MHS</h1>
</body>
</html>