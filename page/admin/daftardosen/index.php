<!-- Tampilan List Prestasi -->
<?php
require_once "model/DosenModel.php";
$dosenModel = new DosenModel();
$daftarDosen = $dosenModel->getAllDosen();
?>

<!-- Content Area -->
<div class="content">
    <div class="kotak-judul">
        <p>Daftar Dosen di Admin</p>
    </div>
    <div class="kotak-konten">
        <div class="action-container" style="margin-bottom: 15px; display: flex; gap: 10px;">
            <!-- Tombol untuk membuka modal -->
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                data-bs-target="#tambahDosenModal">
                <i class="fa fa-plus"></i> Tambah Dosen
            </button>

            <!-- Tombol untuk membuka modal -->
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahByExcel">
                <i class="fa fa-plus"></i> Tambah By Excel
            </button>

            <!-- Tombol untuk mengekspor data Excel -->
            <a href="export_data/export_dosen.php" class="btn btn-success btn-sm">
                <i class="fa fa-file-excel"></i> Export to Excel
            </a>
            <!-- Tombol Export PDF -->
            <a href="export_data/export_dosen_pdf.php" class="btn btn-danger btn-sm">
                <i class="fa fa-file-pdf"></i> Export PDF
            </a>
        </div>

        <?php
        if (isset($_SESSION['success_message'])) {
            echo '<div id="success-alert" class="alert alert-success text-center alert-delete" role="alert">';
            echo $_SESSION['success_message'];
            echo '</div>';
            unset($_SESSION['success_message']); // Hapus pesan setelah ditampilkan
        }

        if (isset($_SESSION['error_message'])) {
            echo '<div id="error-alert" class="alert alert-danger text-center alert-delete" role="alert">';
            echo $_SESSION['error_message'];
            echo '</div>';
            unset($_SESSION['error_message']); // Hapus pesan setelah ditampilkan
        }
        ?>

        <script>
            setTimeout(function () {
                let successAlert = document.getElementById('success-alert');
                let errorAlert = document.getElementById('error-alert');

                if (successAlert) {
                    successAlert.style.transition = 'opacity 0.5s';
                    successAlert.style.opacity = '0';
                    setTimeout(() => successAlert.remove(), 500);
                }
                if (errorAlert) {
                    errorAlert.style.transition = 'opacity 0.5s';
                    errorAlert.style.opacity = '0';
                    setTimeout(() => errorAlert.remove(), 500);
                }
            }, 3000);
        </script>

        <div class="table-container">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>NIP</th>
                        <th>Nama Dosen</th>
                        <th>Jenis Kelamin</th>
                        <th>No. Telp</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($daftarDosen as $dosen) {
                        echo "<tr>";
                        echo "<td>" . $dosen['nip'] . "</td>";
                        echo "<td>" . $dosen['nama'] . "</td>";
                        if ($dosen['jenis_kelamin'] == 'L') {
                            echo "<td>Laki-laki</td>";
                        } else if ($dosen['jenis_kelamin'] == 'P') {
                            echo "<td>Perempuan</td>";
                        }
                        echo "<td>" . $dosen['no_tlp'] . "</td>";
                        echo "<td>" . $dosen['email'] . "</td>";
                        ?>
                        <td style="text-align: center; vertical-align: middle;">
                            <!-- Button untuk menampilkan ID -->
                            <form action="index.php?page=detaildosen" method="POST">
                                <input type="hidden" name="nip" value="<?php echo $dosen['nip']; ?>">
                                <button type="submit" class="btn btn-success btn-sm btn-detail">
                                    <i class="fa fa-edit"></i> Detail
                                </button>
                            </form>


                        </td>
                        <?php
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<!-- Modal Tambah Dosen -->
<div class="modal fade" id="tambahDosenModal" tabindex="-1" aria-labelledby="tambahDosenModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="tambahDosen" action="action/dosen_action.php" method="POST">
                <input type="hidden" name="action" id="action" value="add_dosen">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahDosenModalLabel">Tambah Dosen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Input NIP -->
                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP<span
                        style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="nip" name="nip" placeholder="Masukkan NIP" required>
                    </div>
                    <!-- Input Nama -->
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama<span
                        style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Dosen"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="jenisKelamin" class="form-label">Jenis Kelamin<span
                                style="color: red;">*</span></label>
                        <select class="form-select" id="jenisKelamin" name="jenis_kelamin" required>
                            <option value="" disabled selected>Jenis Kelamin</option>
                            <option value="laki-laki">Laki-Laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">email</label>
                        <input type="text" class="form-control" id="email" name="email"
                            placeholder="Masukkan Email Dosen" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">No. Telp</label>
                        <input type="text" class="form-control" id="no_tlp" name="no_tlp"
                            placeholder="Masukkan No. Telp Dosen" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Mahasiswa by Excel -->
<div class="modal fade" id="tambahByExcel" tabindex="-1" aria-labelledby="tambahByExcelLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="action/dosen_action.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" id="action" value="add_by_excel">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahByExcelLabel">Tambah Mahasiswa via Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="excelFile" class="form-label">Upload File Excel</label>
                        <input type="file" name="excelFile" id="excelFile" class="form-control" accept=".xls,.xlsx"
                            required>
                        <small class="form-text text-muted">Format yang didukung: .xls, .xlsx</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="action" value="add_by_excel">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .dark-mode .form-control,
    .dark-mode .form-select {
        background-color: #355470;
        color: white;
    }

    /* Ganti warna placeholder di mode gelap */
    .dark-mode .form-control::placeholder,
    .dark-mode .form-select::placeholder {
        color: #aaa;
        /* Warna placeholder */
    }
</style>