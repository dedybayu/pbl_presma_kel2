<?php
if (empty($_SESSION['nim']) && empty($_SESSION['username']) && empty($_SESSION['nip'])) {
    // Jika semua session kosong, arahkan ke halaman belum_login
    header("Location: ../belum_login.php");
    exit();
}

// Cek apakah sesi telah kedaluwarsa (lebih dari 30 menit tanpa aktivitas)
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > 1800) {
    // Hapus sesi dan redirect ke halaman login
    session_unset();
    session_destroy();
    header("Location: sesi_habis.php"); // Redirect ke halaman login
    exit();
}

// Update waktu aktivitas terakhir
$_SESSION['LAST_ACTIVITY'] = time();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PresMa Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/page.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/jquery.dataTables.min.css">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css" rel="stylesheet">

    <!-- ICON -->
    <link rel="icon" href="../img/logo.ico" type="image/x-icon" />

</head>

<body id="body" class="light-mode">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-primary custom-navbar fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"
                onclick="toggleSidebar()">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#">PrestasiCore</a>
            <img src="../img/logo.png" alt="Logo" width="30" height="30"
                class="d-inline-block align-text-top logo-navbar">
        </div>
    </nav>
    <?php
    require_once "model/Profile.php";
    $profile = new Profile();
    $key;
    if ($_SESSION['level'] === 'mahasiswa') {
        $key = $_SESSION['nim'];
    } elseif ($_SESSION['level'] === 'dosen') {
        $key = $_SESSION['nip'];
    } elseif ($_SESSION['level'] === 'admin') {
        $key = $_SESSION['username'];
    } else {
        $key = '';
    }
    $row = $profile->getProfile($key);
    ?>