<!-- Content Area -->
<div class="content">
    <!-- Tampilan List Dosen -->
    <?php
    require_once "class_data/data_prestasi.php";
    function getListPrestasi()
    {
        $listPrestasi = new ListPrestasi();
        $listPrestasi = $listPrestasi->getListPrestasi();
        if (!empty($listPrestasi)) {
            foreach ($listPrestasi as $prestasi) {
                echo "<tr>";
                echo "<td>" . $prestasi['nama_lomba'] . "</td>";
                echo "<td>" . "Juara" . $prestasi['juara_lomba'] . "</td>";
                echo "<td>" . $prestasi['tingkat_lomba'] . "</td>";
                echo "<td>" . $prestasi['waktu_pelaksanaan']->format('Y-m-d') . "</td>";
                echo "<td>" . $prestasi['penyelenggara_lomba'] . "</td>";
                ?>
                <td style="text-align: center; vertical-align: middle;">
                    <button class="btn btn-success btn-sm edit_data">
                        <i class="fa fa-edit"></i> Detail
                    </button>
                </td>
                <?php
                echo "</tr>";
                // echo "<option value='" . $['nip'] . "'>- " . htmlspecialchars($dosen['nama']) . "</option>"; // Menampilkan nama dosen
            }
        } else {
            echo "Tidak ada dosen yang ditemukan.";
        }
    }
    ?>


    <div class="kotak-judul">
        <p>Daftar Prestasi <?php echo $row['nama'] ?></p>
    </div><br>
    <div class="container my-4">
        <!-- Membungkus tabel dengan div untuk scroll horizontari-->
        <div class="table-container">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Juara</th>
                        <th>Tingkat</th>
                        <th>Tanggal</th>
                        <th>Penyelenggara</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php getListPrestasi() ?>
                </tbody>
            </table>
        </div>
    </div>
</div>