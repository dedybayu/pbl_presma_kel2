<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <a class="sidebar-class <?php if (isset($_SESSION['page']) && $_SESSION['page'] === 'dashboard') { echo 'active';} ?>" href="index.php"><i class="bi bi-house-fill"></i> Dashboard</a>
    <a class="sidebar-class <?php if (isset($_SESSION['page']) && $_SESSION['page'] === 'inputprestasi') { echo 'active';} ?>" href="index.php?page=inputprestasi"><i class="bi bi-trophy-fill"></i> Input Prestasi</a>
    <a class="sidebar-class <?php if (isset($_SESSION['page']) && $_SESSION['page'] === 'daftarprestasi') { echo 'active';} ?>" href="index.php?page=daftarprestasi"><i class="bi bi-card-list"></i> Daftar Prestasi</a>
    <a class="sidebar-class <?php if (isset($_SESSION['page']) && $_SESSION['page'] === 'profile') { echo 'active';} ?>" href="index.php?page=profile"><i class="bi bi-person-circle"></i> Profile</a>
    <a class="sidebar-class <?php if (isset($_SESSION['page']) && $_SESSION['page'] === 'setting') { echo 'active';} ?>" href="index.php?page=setting"><i class="bi bi-gear-fill"></i> Settings</a>
    <!-- <a class="sidebar-class" href="#"><button class="btn btn-outline-light" id="darkModeToggle"
                onclick="toggleDarkMode()">Dark
                Mode</button></a> -->
    <a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal"><i class="bi bi-box-arrow-right"></i> Log Out</a>
    <!-- Trigger logout modal -->
</div>

