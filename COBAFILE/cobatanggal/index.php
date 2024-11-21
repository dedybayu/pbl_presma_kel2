<?php
require_once 'database.php'; // Pastikan file ini sudah ada dan berisi konfigurasi koneksi database

$db = new Database(); // Pastikan class Database sudah benar dan koneksi dapat dilakukan

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Ambil data tanggal dari form
        $tanggal = $_POST['tanggal'];

        // Pastikan tanggal yang dimasukkan valid
        if (!strtotime($tanggal)) {
            throw new Exception("Tanggal tidak valid.");
        }

        // Query SQL untuk insert data ke tabel tanggal
        $sql = "INSERT INTO tanggal (tanggal) VALUES (?)";

        $params = [$tanggal]; // Mengirimkan tanggal sebagai parameter

        // Eksekusi query
        $stmt = sqlsrv_query($db->conn, $sql, $params);

        if ($stmt === false) {
            throw new Exception("Gagal menyimpan data: " . print_r(sqlsrv_errors(), true));
        }

        echo "Tanggal berhasil disimpan ke database!";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!-- Form untuk input tanggal -->
<form method="POST" action="">
    <label for="tanggal">Tanggal:</label>
    <input type="date" id="tanggal" name="tanggal" required>
    <button type="submit">Submit</button>
</form>
