<!-- Tampilan List Prestasi -->
<?php
require_once "model/MahasiswaModel.php";
$mahasiswaModel = new MahasiswaModel();
$daftarMahasiswa = $mahasiswaModel->getAllMahasiswa();
require_once "model/ProdiModel.php";
$prodiModel = new ProdiModel();
$daftarProdi = $prodiModel->getAllProdi();
?>

<!-- Content Area -->
<div class="content">
    <div class="kotak-judul">
        <p>Daftar Mahasiswa</p>
    </div>

    <div class="kotak-konten">
        <!-- Tombol untuk membuka modal -->
        <div class="action-container" style="margin-bottom: 15px;">
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                data-bs-target="#tambahMahasiswaModal">
                <i class="fa fa-plus"></i> Tambah Mahasiswa
            </button>
        </div>
        <div class="action-container" style="margin-bottom: 15px;">
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                data-bs-target="#tambahByExcel">
                <i class="fa fa-plus"></i> Tambah By Excel
            </button>
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
        <!-- Membungkus tabel dengan div untuk scroll horizontari-->
        <div class="table-container">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Program Studi</th>
                        <th>Jenis Kelamin</th>
                        <th>email</th>
                        <th>No. Tlp</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($daftarMahasiswa as $mahasiswa) {
                        echo "<tr>";
                        echo "<td>" . $mahasiswa['NIM'] . "</td>";
                        echo "<td>" . $mahasiswa['nama'] . "</td>";
                        echo "<td>" . $mahasiswa['prodi'] . "</td>";
                        if ($mahasiswa['jenis_kelamin'] == 'L') {
                            echo "<td>Laki-laki</td>";
                        } else if ($mahasiswa['jenis_kelamin'] == 'P') {
                            echo "<td>Perempuan</td>";
                        }
                        echo "<td>" . $mahasiswa['email'] . "</td>";
                        echo "<td>" . $mahasiswa['no_tlp'] . "</td>";
                        ?>
                        <td style="text-align: center; vertical-align: middle;">
                            <!-- Button untuk menampilkan ID -->
                            <form action="index.php?page=detailmahasiswa" method="POST">
                                <input type="hidden" name="idPrestasi" value="<?php echo $mahasiswa['NIM']; ?>">
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


<div class="modal fade" id="tambahMahasiswaModal" tabindex="-1" aria-labelledby="tambahMahasiswaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="tambahMahasiswa" action="action/mahasiswa_action.php" method="POST">
                <input type="hidden" name="action" id="action" value="add_mahasiswa">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahMahasiswaModalLabel">Tambah Mahasiswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nip" class="form-label">NIM<span
                        style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="nim" name="nim" placeholder="Masukkan NIM" required>
                    </div>
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
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="prodi" class="form-label">Prodi<span
                                style="color: red;">*</span></label>
                        <select class="form-select" id="prodi" name="prodi" required>
                            <option value="" disabled selected>Pilih Prodi</option>
                            <?php
                            foreach ($daftarProdi as $prodi) {
                                echo '<option value="'. $prodi['id'] .'">'. $prodi['nama_prodi'] .'</option>';
                            }
                            ?>
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
            <form action="action/mahasiswa_action.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" id="action" value="add_by_excel">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahByExcelLabel">Tambah Mahasiswa via Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="excelFile" class="form-label">Upload File Excel</label>
                        <input type="file" name="excelFile" id="excelFile" class="form-control" accept=".xls,.xlsx" required>
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