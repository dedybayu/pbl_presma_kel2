<?php
// Koneksi ke SQL Server menggunakan sqlsrv
$servername = "DEDYBAYU_LAPTOP\\SQLEXPRESS";
$uid = ""; // masukkan username di sini
$password = ""; // masukkan password di sini
$database = "latihan_pbl";

$connection = [
    "Database" => $database,
    "UID" => $uid,  // gunakan UID untuk username
    "PWD" => $password
];

$conn = sqlsrv_connect($servername, $connection);

if (!$conn) {
    die(print_r(sqlsrv_errors(), true));
}

// Ambil semua file dari tabel Dokumen2
$sql = "SELECT Id, NamaFile FROM Dokumen2";
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar File</title>
</head>
<body>
    <h2>Daftar File yang Sudah Diunggah</h2>
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama File</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . htmlspecialchars($row['NamaFile']) . "</td>";
                echo "<td><a href='tampilkan.php?id=" . $row['Id'] . "'>Lihat</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>