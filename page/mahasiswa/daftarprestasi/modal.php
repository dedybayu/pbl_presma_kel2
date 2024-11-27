<div class="modal fade" id="detailModal" tabindex="-1"
    aria-labelledby="detailModalLabel" aria-hidden="true">

    <div class="modal-dialog detail-prestasi">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel_<?php echo $modal_prestasi['id']; ?>">
                    Detail
                    Prestasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>ID Lomba:</strong> <?php echo $modal_prestasi['id']; ?></p>
                <p><strong>Nama Lomba:</strong> <?php echo $modal_prestasi['nama_lomba']; ?></p>
                <p><strong>Juara:</strong> <?php echo "Juara " . $modal_prestasi['juara_lomba']; ?>
                </p>
                <p><strong>Tingkat:</strong> <?php echo $modal_prestasi['tingkat_lomba']; ?></p>
                <p><strong>Tanggal:</strong> <?php echo $modal_prestasi['waktu_pelaksanaan']; ?></p>
                <p><strong>Penyelenggara:</strong>
                    <?php echo $modal_prestasi['penyelenggara_lomba']; ?>
                </p>

                <!-- Menampilkan Sertifikat jika ada -->
                <p><strong>Sertifikat:</strong></p>
                <div id="modalFotoContainer_<?php echo $modal_prestasi['id']; ?>">
                    <?php
                    if (!empty($modal_prestasi['file_sertifikat'])) {
                        echo '<img id="modalFoto" src="data:image/jpeg;base64,' . base64_encode($modal_prestasi['file_sertifikat']) . '" alt="Sertifikat" class="img-fluid">';
                    } else {
                        echo '<span id="noFoto">Tidak ada foto</span>';
                    }
                    ?>
                </div>

                <br>

                <!-- Menampilkan foto jika ada -->
                <p><strong>Bukti Foto:</strong></p>
                <div id="modalFotoContainer_<?php echo $modal_prestasi['id']; ?>">
                    <?php
                    if (!empty($modal_prestasi['file_bukti_foto'])) {
                        echo '<img id="modalFoto" src="data:image/jpeg;base64,' . base64_encode($modal_prestasi['file_bukti_foto']) . '" alt="Foto Prestasi" class="img-fluid">';
                    } else {
                        echo '<span id="noFoto">Tidak ada foto</span>';
                    }
                    ?>
                </div>

                <br>

                <!-- Menampilkan proposal jika ada -->
                <p><strong>Proposal:</strong></p>
                <div id="modalProposalContainer_<?php echo $modal_prestasi['id']; ?>">
                    <?php
                    if (!empty($modal_prestasi['file_proposal'])) {
                        // Tampilkan PDF menggunakan <embed>
                        echo '<embed id="modalProposal" src="data:application/pdf;base64,' . base64_encode($modal_prestasi['file_proposal']) . '" width="100%" height="600px">';

                        // Tautan untuk mengunduh file proposal
                        $encodedProposal = base64_encode($modal_prestasi['file_proposal']);
                        $downloadUrl = 'data:application/pdf;base64,' . $encodedProposal;
                        ?>
                        <a style="text-align: right; display: block;" href="<?php echo $downloadUrl; ?>"
                            download="proposal_<?php echo $modal_prestasi['id']; ?>.pdf">
                            Download Proposal
                        </a>
                        <?php
                    } else {
                        echo '<span id="noProposal">Tidak ada proposal</span>';
                    }
                    ?>
                </div>
                <br><br><br>

                <div class="d-flex justify-content-between">
                    <!-- Tombol untuk membuka modal -->
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                        data-bs-target="#confirmDeleteModal" data-id="<?php echo $modal_prestasi['id']; ?>">
                        Hapus
                    </button>

                    <a href="index.php?page=editprestasi&idPrestasi=<?php echo $modal_prestasi['id']; ?>"
                        class="btn btn-primary">Edit</a>
                </div><br>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>