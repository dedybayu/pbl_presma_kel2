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

// Ambil file berdasarkan ID
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $sql = "SELECT NamaFile, DataFile FROM Dokumen2 WHERE Id = ?";
    $params = array($id);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if ($row) {
        // Konversi file ke Base64
        $fileData = base64_encode($row['DataFile']);
        $fileType = mime_content_type_from_extension($row['NamaFile']); // Tentukan MIME Type
        $fileName = htmlspecialchars($row['NamaFile']);
    } else {
        echo "File tidak ditemukan.";
        exit;
    }
} else {
    echo "ID file tidak diberikan.";
    exit;
}

// Fungsi untuk menentukan MIME type berdasarkan ekstensi file
function mime_content_type_from_extension($fileName) {
    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $mime_types = [
        "jpg" => "image/jpeg",
        "jpeg" => "image/jpeg",
        "png" => "image/png",
        "gif" => "image/gif",
        "bmp" => "image/bmp",
        "webp" => "image/webp",
        "pdf" => "application/pdf",
        "mp4" => "video/mp4",
        "webm" => "video/webm",
        "ogg" => "video/ogg",
        "avi" => "video/x-msvideo",
        "mov" => "video/quicktime"
    ];
    return $mime_types[$ext] ?? "application/octet-stream";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tampilkan File</title>
</head>
<body>
    <h2>Pratinjau File: <?php echo $fileName; ?></h2>
    <?php
    if (strpos($fileType, 'image/') === 0) {
        // Jika file adalah gambar
        echo "<img src='data:$fileType;base64,$fileData' alt='Gambar' style='max-width: 100%; height: auto;'>";
    } elseif ($fileType === 'application/pdf') {
        // Jika file adalah PDF
        echo "<embed src='data:$fileType;base64,$fileData' width='100%' height='600px'></embed>";
    } elseif (strpos($fileType, 'video/') === 0) {
        // Jika file adalah video
        echo "<video controls style='max-width: 100%; height: auto;'>
                <source src='data:$fileType;base64,$fileData' type='$fileType'>
                Browser Anda tidak mendukung pratinjau video.
              </video>";
    } else {
        // File lainnya
        echo "<a href='data:$fileType;base64,$fileData' download='$fileName'>Unduh File</a>";
    }
    ?>
    <br><br>
    <a href="output.php">Kembali ke Daftar File</a>
</body>
</html>