<?php
session_start();
require_once 'config/database.php'; // Assuming Database class is saved in Database.php

// Create a Database object to establish a connection
$db = new Database();
$conn = $db->conn; // Access the connection from the Database object

// Check if connection is successful
if (!$conn) {
    die("Failed to connect to the database.");
}

// Query to get the top 3 students
$sql = "
    SELECT TOP 3 m.NIM, m.nama, pr.poin, p.nama_prodi
    FROM mahasiswa m
    JOIN prestasi pr ON m.NIM = pr.NIM
    JOIN prodi p ON m.id_prodi = p.id
    ORDER BY pr.poin DESC;
";

$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$topMahasiswa = [];
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $topMahasiswa[] = $row;
}

// Close the statement and connection
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['level'])) {
        $_SESSION['level'] = $_POST['level']; // Set session level berdasarkan tombol yang dipilih
        header('Location: index.php'); // Redirect ke halaman utama
        exit();
    }
}
?>

<style>
body {
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
    background-color: #f4f4f4;
}

.login-container {
    text-align: center;
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.login-container h1 {
    margin-bottom: 20px;
    color: #333;
}

.prestasi-slider {
    position: relative;
    width: 80%;
    margin: 20px auto;
    overflow: hidden;
}

.prestasi-item {
    display: none;
    text-align: left;
    padding: 20px;
    background: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.prestasi-item.active {
    display: block;
}

.slider-controls {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
}

.slider-controls button {
    padding: 10px 20px;
    font-size: 16px;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.btn-prev {
    background-color: #007bff;
}

.btn-next {
    background-color: #28a745;
}

.login-btn {
    display: inline-block;
    margin: 10px;
    padding: 10px 20px;
    font-size: 16px;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn-mahasiswa {
    background-color: #007bff;
}

.btn-dosen {
    background-color: #28a745;
}

.btn-admin {
    background-color: #dc3545;
}

.login-btn:hover {
    opacity: 0.9;
}

.slider-controls button:hover {
    opacity: 0.9;
}

table {
    width: 80%;
    margin: 20px auto;
    border-collapse: collapse;
    font-family: Arial, sans-serif;
    font-size: 16px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

table thead {
    background-color: #007bff;
    color: #fff;
}

table th,
table td {
    text-align: left;
    padding: 12px 15px;
    border: 1px solid #ddd;
}

table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

table tbody tr:hover {
    background-color: #f1f1f1;
}

table tbody tr td {
    color: #333;
}

table th {
    font-weight: bold;
    text-transform: uppercase;
}

table caption {
    caption-side: top;
    margin-bottom: 10px;
    font-size: 18px;
    font-weight: bold;
    color: #333;
}
</style>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <style>
    /* Styles tetap sama seperti sebelumnya */
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Prestasi Tertinggi Mahasiswa</h2>

        <div class="prestasi-slider">
            <?php foreach ($topMahasiswa as $index => $mahasiswa): ?>
            <div class="prestasi-item <?= $index === 0 ? 'active' : '' ?>">
                <p><strong>NIM:</strong> <?= htmlspecialchars($mahasiswa['NIM']) ?></p>
                <p><strong>Nama:</strong> <?= htmlspecialchars($mahasiswa['nama']) ?></p>
                <p><strong>Poin:</strong> <?= htmlspecialchars($mahasiswa['poin']) ?></p>
                <p><strong>Program Studi:</strong> <?= htmlspecialchars($mahasiswa['nama_prodi']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="slider-controls">
            <button class="btn-prev">Prev</button>
            <button class="btn-next">Next</button>
        </div>

        <h1>Login Sebagai</h1>
        <form method="POST" action="">
            <button type="submit" name="level" value="mahasiswa" class="login-btn btn-mahasiswa">Mahasiswa</button>
            <button type="submit" name="level" value="dosen" class="login-btn btn-dosen">Dosen</button>
            <button type="submit" name="level" value="admin" class="login-btn btn-admin">Admin</button>
        </form>
    </div>

    <script>
    const items = document.querySelectorAll('.prestasi-item');
    const prevButton = document.querySelector('.btn-prev');
    const nextButton = document.querySelector('.btn-next');
    let currentIndex = 0;

    function showItem(index) {
        items.forEach((item, i) => {
            item.classList.toggle('active', i === index);
        });
    }

    prevButton.addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + items.length) % items.length;
        showItem(currentIndex);
    });

    nextButton.addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % items.length;
        showItem(currentIndex);
    });
    </script>
</body>

</html>