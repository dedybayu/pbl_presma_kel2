<!-- Content Area -->
<div class="content">
    <!-- Tampilan List Dosen -->
    <?php
    require_once "class_data/data_prestasi.php";
    $listPrestasi = new ListPrestasi();
    $daftarPrestasi = $listPrestasi->getListPrestasi($_SESSION['nim']);
    function getListPrestasi($daftarPrestasi)
    {
        if (!empty($daftarPrestasi)) {
            foreach ($daftarPrestasi as $prestasi) {
                echo "<tr>";
                echo "<td>" . $prestasi['nama_lomba'] . "</td>";
                echo "<td>" . "Juara" . $prestasi['juara_lomba'] . "</td>";
                echo "<td>" . $prestasi['tingkat_lomba'] . "</td>";
                echo "<td>" . $prestasi['waktu_pelaksanaan']->format('Y-m-d') . "</td>";
                echo "<td>" . $prestasi['penyelenggara_lomba'] . "</td>";
                ?>
                <td style="text-align: center; vertical-align: middle;">
                    <button class="btn btn-success btn-sm edit_data" 
                            data-bs-toggle="modal" 
                            data-bs-target="#detailModal" 
                            data-nama="<?php echo htmlspecialchars($prestasi['nama_lomba']); ?>" 
                            data-juara="<?php echo htmlspecialchars($prestasi['juara_lomba']); ?>" 
                            data-tingkat="<?php echo htmlspecialchars($prestasi['tingkat_lomba']); ?>" 
                            data-tanggal="<?php echo $prestasi['waktu_pelaksanaan']->format('Y-m-d'); ?>" 
                            data-penyelenggara="<?php echo htmlspecialchars($prestasi['penyelenggara_lomba']); ?>">
                        <i class="fa fa-edit"></i> Detail
                    </button>
                </td>
                <?php
                echo "</tr>";
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
                    <?php getListPrestasi($daftarPrestasi) ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 
    // $prestasiById = 
?>
<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Prestasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nama Lomba:</strong> <span id="modalNama"></span></p>
                <p><strong>Juara:</strong> <span id="modalJuara"></span></p>
                <p><strong>Tingkat:</strong> <span id="modalTingkat"></span></p>
                <p><strong>Tanggal:</strong> <span id="modalTanggal"></span></p>
                <p><strong>Penyelenggara:</strong> <span id="modalPenyelenggara"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    // Event listener for buttons with class 'edit_data'
    document.querySelectorAll('.edit_data').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('modalNama').textContent = this.getAttribute('data-nama');
            document.getElementById('modalJuara').textContent = "Juara " + this.getAttribute('data-juara');
            document.getElementById('modalTingkat').textContent = this.getAttribute('data-tingkat');
            document.getElementById('modalTanggal').textContent = this.getAttribute('data-tanggal');
            document.getElementById('modalPenyelenggara').textContent = this.getAttribute('data-penyelenggara');
        });
    });
</script>