<!-- Tampilan List Prestasi -->
<?php
require_once "model/PrestasiModel.php";
if (isset($_SESSION['edit_prestasi_id'])) {
    unset($_SESSION['edit_prestasi_id']);
}
$listPrestasi = new PrestasiModel();
$daftarPrestasi = $listPrestasi->getAllPrestasi();
?>

<!-- Content Area -->
<div class="content">


    <div class="kotak-judul">
        <p>Daftar Semua Prestasi</p>
    </div>



    <style>
        .alert-delete {
            max-width: 70%;
            margin: 0 auto;
            text-align: center;
        }
    </style>
    <div class="kotak-konten">

        <?php
        if (empty($daftarPrestasi)) {
            ?>

            <div class="container">
                <h1>Anda Belum Memiliki Prestasi</h1>
                <br>
                <div class="d-flex justify-content-center">
                    <a href="index.php?page=inputprestasi" class="btn btn-primary">Tambah Prestasi</a>
                </div>
                <br>
            </div>
            <?php
        } else {
            ?>
            <div class="table-container">
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
                <br>
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Mahasiswa</th>
                            <th>Nama Lomba</th>
                            <th>Juara</th>
                            <th>Status Tim</th>
                            <th>Tingkat</th>
                            <th>Tanggal</th>
                            <th>Penyelenggara</th>
                            <th>Poin</th>
                            <th>Upload Date</th>
                            <th>Status Verifikasi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($daftarPrestasi as $prestasi) {
                            // $modal_prestasi = $prestasi;
                            echo "<tr>";
                            echo "<td>" . $prestasi['nama_mhs'] . "</td>";
                            echo "<td>" . $prestasi['nama_lomba'] . "</td>";
                            echo "<td>" . "Juara " . $prestasi['juara_lomba'] . "</td>";
                            echo "<td>" . $prestasi['status_tim'] . "</td>";
                            echo "<td>" . $prestasi['tingkat_lomba'] . "</td>";
                            echo "<td>" . $prestasi['waktu_pelaksanaan']->format('j F Y') . "</td>";
                            echo "<td>" . $prestasi['penyelenggara_lomba'] . "</td>";
                            echo "<td>" . $prestasi['poin'] . "</td>";
                            echo "<td>" . $prestasi['upload_date']->format('d-m-Y H:i') . "</td>";
                            echo "<td>" . $prestasi['status_verifikasi'] . "</td>";
                            ?>
                            <td style="text-align: center; vertical-align: middle;">
                                <!-- Button untuk menampilkan ID -->
                                <form action="index.php?page=detailprestasi" method="POST">
                                    <input type="hidden" name="idPrestasi" value="<?php echo $prestasi['id']; ?>">
                                    <button type="submit" class="btn btn-success btn-sm btn-detail">
                                        <i class="fa fa-edit"></i> Detail
                                    </button>
                                </form>


                            </td>
                            <?php
                            echo "</tr>";

                            // Modal for each prestasi
                            ?>

                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php
        }
        ?>

    </div>
</div>
</div>