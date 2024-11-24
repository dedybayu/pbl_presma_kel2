<!-- Content Area -->
<div class="content">
    <!-- Tampilan List Prestasi -->
    <?php
    require_once "class_data/data_prestasi.php";
    $listPrestasi = new ListPrestasi();
    $daftarPrestasi = $listPrestasi->getListPrestasi($_SESSION['nim']);
    ?>

    <div class="kotak-judul">
        <p>Daftar Prestasi <?php echo $row['nama']; ?></p>
    </div><br>

    <div class="container my-4">
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
                    <?php
                    if (!empty($daftarPrestasi)) {
                        foreach ($daftarPrestasi as $prestasi) {
                            echo "<tr>";
                            echo "<td>" . $prestasi['nama_lomba'] . "</td>";
                            echo "<td>" . "Juara " . $prestasi['juara_lomba'] . "</td>";
                            echo "<td>" . $prestasi['tingkat_lomba'] . "</td>";
                            echo "<td>" . $prestasi['waktu_pelaksanaan'] . "</td>";
                            echo "<td>" . $prestasi['penyelenggara_lomba'] . "</td>";
                            ?>
                            <td style="text-align: center; vertical-align: middle;">
                                <!-- Button to open modal, passing prestasi ID -->
                                <button class="btn btn-success btn-sm btn-detail" data-bs-toggle="modal" data-bs-target="#detailModal_<?php echo $prestasi['id']; ?>">
                                    <i class="fa fa-edit"></i> Detail
                                </button>
                            </td>
                            <?php
                            echo "</tr>";
                            
                            // Modal for each prestasi
                            ?>
                            <div class="modal fade" id="detailModal_<?php echo $prestasi['id']; ?>" tabindex="-1" aria-labelledby="detailModalLabel_<?php echo $prestasi['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog detail-prestasi">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="detailModalLabel_<?php echo $prestasi['id']; ?>">Detail Prestasi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>ID Lomba:</strong> <?php echo $prestasi['id']; ?></p>
                                            <p><strong>Nama Lomba:</strong> <?php echo $prestasi['nama_lomba']; ?></p>
                                            <p><strong>Juara:</strong> <?php echo "Juara " . $prestasi['juara_lomba']; ?></p>
                                            <p><strong>Tingkat:</strong> <?php echo $prestasi['tingkat_lomba']; ?></p>
                                            <p><strong>Tanggal:</strong> <?php echo $prestasi['waktu_pelaksanaan']; ?></p>
                                            <p><strong>Penyelenggara:</strong> <?php echo $prestasi['penyelenggara_lomba']; ?></p>

                                            <!-- Menampilkan foto jika ada -->
                                            <p><strong>Bukti Foto:</strong></p>
                                            <div id="modalFotoContainer_<?php echo $prestasi['id']; ?>">
                                                <?php
                                                if ($prestasi['file_bukti_foto']) {
                                                    echo '<img id="modalFoto" src="data:image/jpeg;base64,' . base64_encode($prestasi['file_bukti_foto']) . '" alt="Foto Prestasi" class="img-fluid">';
                                                } else {
                                                    echo '<span id="noFoto">Tidak ada foto</span>';
                                                }
                                                ?>
                                            </div>

                                            <br>

                                            <!-- Menampilkan proposal jika ada -->
                                            <p><strong>Proposal:</strong></p>
                                            <div id="modalProposalContainer_<?php echo $prestasi['id']; ?>">
                                                <?php
                                                if ($prestasi['file_proposal']) {
                                                    echo '<embed id="modalProposal" src="data:application/pdf;base64,' . base64_encode($prestasi['file_proposal']) . '" width="100%" height="600px">';
                                                } else {
                                                    echo '<span id="noProposal">Tidak ada proposal</span>';
                                                }
                                                ?>
                                            </div><br><br>

                                            <div class="d-flex justify-content-center">
                                                <form action="hapus_prestasi.php" method="POST">
                                                    <input type="hidden" name="prestasiId" value="<?php echo $prestasi['id']; ?>">
                                                    <button type="submit" class="btn btn-danger">Hapus Prestasi</button>
                                                </form>
                                            </div>

                                        </div>
                                        <div class="modal-footer d-flex justify-content-between">
                                            <form action="../page/edit_prestasi/index.php" method="POST">
                                                <input type="hidden" name="prestasiId" value="<?php echo $prestasi['id']; ?>">
                                                <button type="submit" class="btn btn-primary">Edit</button>
                                            </form>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "Tidak ada prestasi yang ditemukan.";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
session_start();
if (isset($_SESSION['success_message'])) {
    echo '<div class="alert alert-success text-center" role="alert">';
    echo $_SESSION['success_message'];
    echo '</div>';
    unset($_SESSION['success_message']); // Hapus pesan setelah ditampilkan
}

if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger text-center" role="alert">';
    echo $_SESSION['error_message'];
    echo '</div>';
    unset($_SESSION['error_message']); // Hapus pesan setelah ditampilkan
}
?>


<style>
    /* Modal style untuk semua modal */
    .modal-dialog {
        max-width: 1300px;
        width: 95%;
    }

    .modal-body {
        max-height: 70vh;
        overflow-y: auto;
    }

    /* Gambar Foto */
    .modal-body #modalFoto {
        height: auto;
        display: block;
        margin: 0 auto;
        border: 5px solid #00a7e1;
        border-radius: 8px;
    }

    .dark-mode .modal-body #modalFoto {
        border: 5px solid #528fad;
    }

    /* Proposal */
    .modal-body #modalProposal {
        width: 100%;
        height: 600px;
    }

    /* Menyembunyikan konten bila tidak ada foto atau proposal */
    .modal-body #noFoto,
    .modal-body #noProposal {
        display: none;
        color: #999;
    }

    /* Modal style untuk modal foto */
    .modal-body #modalFotoContainer img {
        width: 100%;
        max-width: 800px;
        border-radius: 8px;
        border: 3px solid #ccc;
    }

    /* Styling the 'Tidak ada foto' message */
    .modal-body #noFoto,
    .modal-body #noProposal {
        color: #999;
        font-style: italic;
    }

    /* Styling untuk tombol Hapus dan Edit */
    .modal-footer form button {
        width: 150px;
        font-size: 14px;
    }

    /* Penyesuaian untuk modal container */
    .modal-content {
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
</style>
