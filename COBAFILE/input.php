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
} else {
    // Cek apakah file telah diunggah
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
        // Ambil informasi file
        $fileName = $_FILES['file']['name'];
        $fileSize = $_FILES['file']['size'];
        $fileTmp = $_FILES['file']['tmp_name'];
    
        // Maksimal ukuran file (1 MB)
        $maxFileSize = 1 * 1024 * 1024;
    
        // Validasi ukuran file
        if ($fileSize > $maxFileSize) {
            echo "Ukuran file terlalu besar. Maksimal 1 MB.";
            exit;
        }
    
        // Baca file sebagai data biner
        $fileData = file_get_contents($fileTmp);
    
        // Query untuk menyimpan file ke database
        $sql = "INSERT INTO Dokumen2 (NamaFile, DataFile) VALUES (?, CONVERT(VARBINARY(MAX), ?))";
        $params = array($fileName, $fileData);
        $stmt = sqlsrv_query($conn, $sql, $params);
    
        // Eksekusi dan cek keberhasilan
        if ($stmt) {
            echo "File berhasil diupload dan disimpan ke database!";
        } else {
            echo "Gagal menyimpan file ke database.";
            die(print_r(sqlsrv_errors(), true));
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File</title>
</head>
<body>
    <h2>Upload File ke Database (SQL Server)</h2>
    <form action="input.php" method="post" enctype="multipart/form-data">
        <label for="file">Pilih File:</label>
        <input type="file" name="file" id="file" required>
        <br><br>
        <button type="submit">Upload</button>
    </form>
</body>
</html>