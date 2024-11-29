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
                        echo "<td>" . $dosen['jenis_kelamin'] . "</td>";
                        echo "<td>" . $dosen['no_tlp'] . "</td>";
                        echo "<td>" . $dosen['email'] . "</td>";
                        ?>
                        <td style="text-align: center; vertical-align: middle;">
                            <!-- Button untuk menampilkan ID -->
                            <form action="index.php?page=detaildosen" method="POST">
                                <input type="hidden" name="idPrestasi" value="<?php echo $dosen['nip']; ?>">
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