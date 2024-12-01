    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <a class="sidebar-class  <?php if (isset($_SESSION['page']) && $_SESSION['page'] === 'dashboard') { echo 'active';} ?>" " href="index.php"><i class="bi bi-house-fill"></i> Dashboard</a>
        <a class="sidebar-class  <?php if (isset($_SESSION['page']) && $_SESSION['page'] === 'daftarprestasi') { echo 'active';} ?>" " href="index.php?page=daftarprestasi"><i class="bi bi-trophy-fill"></i> Daftar Prestasi</a>
        <a class="sidebar-class  <?php if (isset($_SESSION['page']) && $_SESSION['page'] === 'daftarmahasiswa') { echo 'active';} ?>" " href="index.php?page=daftarmahasiswa"><i class="bi bi-card-list"></i> Daftar Mahasiswa</a>
        <a class="sidebar-class  <?php if (isset($_SESSION['page']) && $_SESSION['page'] === 'daftardosen') { echo 'active';} ?>" " href="index.php?page=daftardosen"><i class="bi bi-card-list"></i> Daftar Dosen</a>
        <a class="sidebar-class  <?php if (isset($_SESSION['page']) && $_SESSION['page'] === 'setting') { echo 'active';} ?>" " href="index.php?page=setting"><i class="bi bi-gear-fill"></i> Settings</a>
        <a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal"><i class="bi bi-box-arrow-right"></i> Log Out</a> <!-- Trigger logout modal -->
    </div>