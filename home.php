<?php
session_start();
if (!isset($_SESSION['username'])) {
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
    <h1>Halooooo ADMIN</h1>
</body>
</html>