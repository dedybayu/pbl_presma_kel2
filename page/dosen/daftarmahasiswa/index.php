<!-- Tampilan List Prestasi -->
<?php
require_once "model/MahasiswaModel.php";
$mahasiswaModel = new MahasiswaModel();
$daftarMahasiswa = $mahasiswaModel->getMahasiswaByDosbim($_SESSION['nip']);
?>

<!-- Content Area -->
<div class="content">
    <div class="kotak-judul">
        <p>Daftar Mahasiswa Bimbingan Anda</p>
    </div>

    <div class="kotak-konten">
        <div class="action-container" style="margin-bottom: 15px; display: flex; gap: 10px;">
            <!-- Tombol untuk mengekspor data Excel -->
            <form action="export_data/export_mahasiswa_fromdosen.php" method="post">
                <input type="hidden" name="nip" id="nip" value="<?= $_SESSION['nip'] ?>">
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="fa fa-file-excel"></i> Export to Excel
                </button>
            </form>
            <form action="export_data/export_mahasiswa_pdf_fromdosen.php" method="post">
                <input type="hidden" name="nip" id="nip" value="<?= $_SESSION['nip'] ?>">
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fa fa-file-excel"></i> Export to Pdf
                </button>
            </form>
        </div>



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
                        echo "<td>" . $mahasiswa['nama_prodi'] . "</td>";
                        echo "<td>" . $mahasiswa['jenis_kelamin'] . "</td>";
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