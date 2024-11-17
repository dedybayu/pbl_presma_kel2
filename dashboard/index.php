<?php
session_start();
if (!isset($_SESSION['username'])) {
    // Jika session tidak ada, arahkan ke halaman login
    header("Location: ../blm.php");
    exit();
}
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
</head>

<body id="body" class="light-mode">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-primary custom-navbar fixed-top">
        <nav class="navbar navbar-expand-lg navbar-light bg-primary custom-navbar fixed-top">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"
                    onclick="toggleSidebar()">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="#">Pencatatan Prestasi Mahasiswa</a>
                <img src="../img/example-logo.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top logo-navbar">
            </div>
        </nav>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <a class="active" href="#">Dashboard</a>
        <a href="#">Profile</a>
        <a href="#">Settings</a>
        <a href=""><button class="btn btn-outline-light" id="darkModeToggle" onclick="toggleDarkMode()">Dark
                Mode</button></a>
        <a href="../fungsi/logout.php">Log Out</a>
    </div>

    <!-- Content Area -->
    <div class="content">
        <!-- <h1>Welcome to the Dashboard</h1>
        <p>This is the main content area.</p> -->
        <!-- Add more content as needed -->
        <div class="kotak-judul">
            <p>SELAMAT DATANG DI SISTEM PENCATATAN PRESTASI MAHASISWA</p>
        </div>
    </div>

    <!-- Bootstrap 5 JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS for Sidebar Toggle and Dark Mode -->
    <script>
        // Function to toggle sidebar visibility
        function toggleSidebar() {
            var sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
            var navbarTogglerIcon = document.querySelector('.navbar-toggler-icon');
            if (sidebar.classList.contains('active')) {
                navbarTogglerIcon.style.transform = 'scale(0.8)';  // Mengecilkan ikon saat sidebar terbuka
            } else {
                navbarTogglerIcon.style.transform = 'scale(1)';  // Kembalikan ukuran normal saat sidebar ditutup
            }
        }

        // Function to toggle dark mode
        function toggleDarkMode() {
            var body = document.getElementById('body');
            var darkModeToggle = document.getElementById('darkModeToggle');

            // Toggle between light and dark mode classes
            body.classList.toggle('dark-mode');
            if (body.classList.contains('dark-mode')) {
                localStorage.setItem('theme', 'dark'); // Save preference
                darkModeToggle.textContent = 'Light Mode'; // Change button text
            } else {
                localStorage.setItem('theme', 'light'); // Save preference
                darkModeToggle.textContent = 'Dark Mode'; // Change button text
            }
        }

        // Check local storage for theme preference and apply it
        window.onload = function () {
            var savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.getElementById('body').classList.add('dark-mode');
                document.getElementById('darkModeToggle').textContent = 'Light Mode'; // Set button text
            }
        };
    </script>

</body>

</html>