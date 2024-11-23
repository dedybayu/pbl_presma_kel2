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
                        <th>Upload Date</th>
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
                            echo "<td>" . $prestasi['upload_date']->format('d-m-Y H:i') . "</td>";
                            ?>
                            <td style="text-align: center; vertical-align: middle;">
                                <!-- Button to open modal, passing prestasi ID -->
                                <button class="btn btn-success btn-sm btn-detail" data-bs-toggle="modal"
                                    data-bs-target="#detailModal_<?php echo $prestasi['id']; ?>">
                                    <i class="fa fa-edit"></i> Detail
                                </button>
                            </td>
                            <?php
                            echo "</tr>";

                            // Modal for each prestasi
                            ?>
                            <div class="modal fade" id="detailModal_<?php echo $prestasi['id']; ?>" tabindex="-1"
                                aria-labelledby="detailModalLabel_<?php echo $prestasi['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog detail-prestasi">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="detailModalLabel_<?php echo $prestasi['id']; ?>">Detail
                                                Prestasi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>ID Lomba:</strong> <?php echo $prestasi['id']; ?></p>
                                            <p><strong>Nama Lomba:</strong> <?php echo $prestasi['nama_lomba']; ?></p>
                                            <p><strong>Juara:</strong> <?php echo "Juara " . $prestasi['juara_lomba']; ?></p>
                                            <p><strong>Tingkat:</strong> <?php echo $prestasi['tingkat_lomba']; ?></p>
                                            <p><strong>Tanggal:</strong> <?php echo $prestasi['waktu_pelaksanaan']; ?></p>
                                            <p><strong>Penyelenggara:</strong> <?php echo $prestasi['penyelenggara_lomba']; ?>
                                            </p>

                                            <!-- Menampilkan foto jika ada -->
                                            <p><strong>Bukti Foto:</strong></p>
                                            <div id="modalFotoContainer_<?php echo $prestasi['id']; ?>">
                                                <?php
                                                if (!empty($prestasi['file_bukti_foto'])) {
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
                                                if (!empty($prestasi['file_proposal'])) {
                                                    echo '<embed id="modalProposal" src="data:application/pdf;base64,' . base64_encode($prestasi['file_proposal']) . '" width="100%" height="600px">';
                                                } else {
                                                    echo '<span id="noProposal">Tidak ada proposal</span>';
                                                }
                                                ?>
                                            </div><br><br>

                                            <div class="d-flex justify-content-between">
                                                <form action="fungsi/hapus_prestasi.php" method="POST">
                                                    <input type="hidden" name="prestasiId"
                                                        value="<?php echo $prestasi['id']; ?>">
                                                    <button type="submit" class="btn btn-danger">Hapus Prestasi</button>
                                                </form>

                                                <form action="fungsi/edit_prestasi.php" method="POST" class="me-auto">
                                                    <input type="hidden" name="prestasiId"
                                                        value="<?php echo $prestasi['id']; ?>">
                                                    <button type="submit" class="btn btn-primary">Edit</button>
                                                </form>
                                                
                                            </div>                                                
                                        </div>
                                        <div class="modal-footer d-flex justify-content-center">

                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Tutup</button>
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


<style>
    /* Modal style untuk detailModal */
    .modal-dialog {
        max-width: 1300px;
        width: 90%;
    }

    .modal-body {
        max-height: 70vh;
        overflow-y: auto;
    }

    #modalFoto {
        height: auto;
        /* Menjaga proporsi tinggi */
        display: block;
        /* Menampilkan sebagai blok */
        margin: 0 auto;
        /* Mengatur margin otomatis untuk pusat */
        border: 5px solid #00a7e1;
        /* Menambahkan border dengan warna hitam */
        border-radius: 8px;
        /* Menambahkan sudut melengkung (opsional) */
    }

    .dark-mode #modalFoto {
        border: 5px solid #528fad;
        /* Menambahkan border dengan warna hitam */
    }


     #modalProposal {
        width: 100%;
        height: 600px;
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
</style>