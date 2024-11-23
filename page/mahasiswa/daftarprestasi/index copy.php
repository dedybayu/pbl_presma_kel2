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
                                <button class="btn btn-success btn-sm btn-detail" data-id="<?php echo $prestasi['id']; ?>"
                                    data-nama="<?php echo $prestasi['nama_lomba']; ?>"
                                    data-juara="<?php echo $prestasi['juara_lomba']; ?>"
                                    data-tingkat="<?php echo $prestasi['tingkat_lomba']; ?>"
                                    data-tanggal="<?php echo $prestasi['waktu_pelaksanaan']; ?>"
                                    data-penyelenggara="<?php echo $prestasi['penyelenggara_lomba']; ?>"
                                    data-foto="<?php echo base64_encode($prestasi['file_bukti_foto'] ?? ''); ?>"
                                    data-proposal="<?php echo base64_encode($prestasi['file_proposal'] ?? ''); ?>"
                                    data-bs-toggle="modal" data-bs-target="#detailModal">
                                    <i class="fa fa-edit"></i> Detail
                                </button>
                            </td>
                            <?php
                            echo "</tr>";
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

<!-- Modal Detail Prestasi (Statis) -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog detail-prestasi">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Prestasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>ID Lomba:</strong> <span id="prestasiId"></span></p>
                <p><strong>Nama Lomba:</strong> <span id="modalNamaLomba"></span></p>
                <p><strong>Juara:</strong> <span id="modalJuaraLomba"></span></p>
                <p><strong>Tingkat:</strong> <span id="modalTingkatLomba"></span></p>
                <p><strong>Tanggal:</strong> <span id="modalTanggalLomba"></span></p>
                <p><strong>Penyelenggara:</strong> <span id="modalPenyelenggaraLomba"></span></p>

                <!-- Menampilkan foto jika ada -->
                <p><strong>Bukti Foto:</strong></p>
                <div id="modalFotoContainer">
                    <img id="modalFoto" src="" alt="Foto Prestasi">
                    <span id="noFoto" style="display:none;">Tidak ada foto</span>
                </div>

                <br>

                <!-- Menampilkan proposal jika ada -->
                <p><strong>Proposal:</strong></p>
                <div id="modalProposalContainer">
                    <embed id="modalProposal" src="" width="100%" height="600px">
                    <span id="noProposal" style="display:none;">Tidak ada proposal</span>
                </div><br><br>
                <div class="d-flex justify-content-center">
                    <form action="hapus_prestasi.php" method="POST">
                        <input type="hidden" name="prestasiId" id="prestasiId">
                        <button type="submit" class="btn btn-danger">Hapus Prestasi</button>
                    </form>
                    <form action="../page/edit_prestasi/index.php" method="POST">
                        <input type="hidden" name="prestasiId" id="prestasiId">
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </form>
                </div>

            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript untuk memperbarui modal dengan data yang sesuai
    document.querySelectorAll('.btn-detail').forEach(function (button) {
        button.addEventListener('click', function () {
            const prestasiId = this.getAttribute('data-id');
            const namaLomba = this.getAttribute('data-nama');
            const juaraLomba = this.getAttribute('data-juara');
            const tingkatLomba = this.getAttribute('data-tingkat');
            const tanggalLomba = this.getAttribute('data-tanggal');
            const penyelenggaraLomba = this.getAttribute('data-penyelenggara');
            const foto = this.getAttribute('data-foto');
            const proposal = this.getAttribute('data-proposal');

            // Update modal dengan data prestasi
            document.getElementById('prestasiId').value = prestasiId;
            document.getElementById('modalNamaLomba').textContent = namaLomba;
            document.getElementById('modalJuaraLomba').textContent = juaraLomba;
            document.getElementById('modalTingkatLomba').textContent = tingkatLomba;
            document.getElementById('modalTanggalLomba').textContent = tanggalLomba;
            document.getElementById('modalPenyelenggaraLomba').textContent = penyelenggaraLomba;

            // Update foto
            const modalFoto = document.getElementById('modalFoto');
            const noFoto = document.getElementById('noFoto');
            const modalFotoContainer = document.getElementById('modalFotoContainer');
            if (foto) {
                modalFoto.src = 'data:image/jpeg;base64,' + foto;
                modalFoto.style.display = 'block';
                noFoto.style.display = 'none';
            } else {
                modalFoto.style.display = 'none';
                noFoto.style.display = 'block';
            }

            // Update proposal
            const modalProposal = document.getElementById('modalProposal');
            const noProposal = document.getElementById('noProposal');
            const modalProposalContainer = document.getElementById('modalProposalContainer');
            if (proposal) {
                modalProposal.src = 'data:application/pdf;base64,' + proposal;
                modalProposal.style.display = 'block';
                noProposal.style.display = 'none';
            } else {
                modalProposal.style.display = 'none';
                noProposal.style.display = 'block';
            }
        });
    });
</script>

<style>
    /* Modal style untuk detailModal */
    #detailModal .modal-dialog {
        max-width: 1300px;
        width: 90%;
    }

    #detailModal .modal-body {
        max-height: 70vh;
        overflow-y: auto;
    }

    #detailModal #modalFoto {
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

    .dark-mode #detailModal #modalFoto {
        border: 5px solid #528fad;
        /* Menambahkan border dengan warna hitam */
    }


    #detailModal #modalProposal {
        width: 100%;
        height: 600px;
    }

    /* Menyembunyikan konten bila tidak ada foto atau proposal */
    #detailModal #noFoto,
    #detailModal #noProposal {
        display: none;
        color: #999;
    }
</style>