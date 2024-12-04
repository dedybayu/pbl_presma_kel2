<!-- Tampilan List Prestasi -->
<?php
require_once "model/PrestasiModel.php";
$listPrestasi = new PrestasiModel();
$daftarPrestasi = $listPrestasi->getPrestasiByDosen($_SESSION['nip']);
?>

<!-- Content Area -->
<div class="content">
    <div class="kotak-judul">
        <p>Daftar Prestasi Bimbingan Anda</p>
    </div>

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