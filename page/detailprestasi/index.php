<div class="content">
    <!-- Tampilan List Prestasi -->
    <?php
    require_once "model/PrestasiModel.php";
    $idPrestasi;
    if (!empty($_POST['idPrestasi'])) {
        $idPrestasi = $_POST['idPrestasi'];
    } else if (isset($_SESSION['edit_prestasi_id'])) {
        $idPrestasi = $_SESSION['edit_prestasi_id'];
    } else {
        $idPrestasi = null;
    }

    $prestasiModel = new PrestasiModel();
    $prestasi = $prestasiModel->getPrestasiById($idPrestasi);
    ?>

    <div class="kotak-judul d-flex align-items-center justify-content-between" style="padding-bottom: 15px">
        <a type="button" href="index.php?page=daftarprestasi" class="btn btn-primary"> Kembali </a>
        <p class="mb-0 flex-grow-1 text-center">Detail Prestasi</p>
    </div>

    <div class="kotak-konten">
        <div class="container">
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

            <?php
            if ($_SESSION['level'] === 'admin' || $_SESSION['level'] === 'dosen') {
                echo "<p><strong>Nama Mahasiswa:</strong> " . $prestasi['nama_mhs'] . "</p>";

            }
            ?>
            <!-- Informasi Lomba -->
            <div class="col-12 col-md-6 box-transparen">
                <table class="table table-borderless align-middle">
                    <tbody>
                        <tr>
                            <td class="text-nowrap"><strong>Nama Lomba</strong></td>
                            <td class="colon">:</td>
                            <td><strong><?= $prestasi['nama_lomba']; ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-nowrap"><strong>Juara</strong></td>
                            <td class="colon">:</td>
                            <td><strong>Juara <?= $prestasi['juara_lomba']; ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-nowrap"><strong>Status Tim</strong></td>
                            <td class="colon">:</td>
                            <td><strong><?= $prestasi['status_tim']; ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-nowrap"><strong>Tingkat</strong></td>
                            <td class="colon">:</td>
                            <td><strong><?= ucfirst(strtolower($prestasi['tingkat_lomba'])); ?>
                                </strong></td>
                        </tr>
                        <tr>
                            <td class="text-nowrap"><strong>Tanggal Lomba</strong></td>
                            <td class="colon">:</td>
                            <td><strong><?= $prestasi['waktu_pelaksanaan']->format('j F Y'); ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-nowrap"><strong>Penyelenggara</strong></td>
                            <td class="colon">:</td>
                            <td><strong><?= $prestasi['penyelenggara_lomba']; ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <br>

            <!-- Grid for 4 Photos with Responsive 1 Column on Small Screens -->
            <div class="row g-4">
                <!-- Photo 1 -->
                <div class="col-12 col-md-6 foto-box">
                    <p><strong>Sertifikat:</strong></p>
                    <div class="FotoContainer">
                        <?php
                        if (!empty($prestasi['file_sertifikat'])) {
                            echo '<img class="foto-modal-trigger img-fluid" src="data:image/jpeg;base64,' . base64_encode($prestasi['file_sertifikat']) . '" alt="Sertifikat" data-title="Sertifikat">';
                        } else {
                            echo '<span id="noFoto">Tidak ada foto</span>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Photo 2 -->
                <div class="col-12 col-md-6 foto-box">
                    <p><strong>Foto Saat Perlombaan:</strong></p>
                    <div class="FotoContainer">
                        <?php
                        if (!empty($prestasi['file_bukti_foto'])) {
                            echo '<img class="foto-modal-trigger img-fluid" src="data:image/jpeg;base64,' . base64_encode($prestasi['file_bukti_foto']) . '" alt="Foto Prestasi" data-title="Foto Saat Perlombaan">';
                        } else {
                            echo '<span id="noFoto">Tidak ada foto</span>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Photo 3 -->
                <div class="col-12 col-md-6 foto-box">
                    <p><strong>Surat Undangan:</strong></p>
                    <div class="FotoContainer">
                        <?php
                        if (!empty($prestasi['file_surat_undangan'])) {
                            echo '<img class="foto-modal-trigger img-fluid" src="data:image/jpeg;base64,' . base64_encode($prestasi['file_surat_undangan']) . '" alt="Surat Undangan" data-title="Surat Undangan">';
                        } else {
                            echo '<span id="noFoto">Tidak ada surat undangan</span>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Photo 4 -->
                <div class="col-12 col-md-6 foto-box">
                    <p><strong>Surat Tugas:</strong></p>
                    <div class="FotoContainer">
                        <?php
                        if (!empty($prestasi['file_surat_tugas'])) {
                            echo '<img class="foto-modal-trigger img-fluid" src="data:image/jpeg;base64,' . base64_encode($prestasi['file_surat_tugas']) . '" alt="Surat Tugas" data-title="Surat Tugas">';
                        } else {
                            echo '<span id="noFoto">Tidak ada surat tugas</span>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <br><br>

            <div class="row g-4 pdf-box">
                <p><strong>Proposal:</strong></p>
                <div class="ProposalContainer" class="text-center">
                    <?php
                    if (!empty($prestasi['file_proposal'])) {
                        // Tampilkan PDF menggunakan <embed>
                        echo '<embed id="Proposal" src="data:application/pdf;base64,' . base64_encode($prestasi['file_proposal']) . '" width="100%" height="650px">';

                        // Tautan untuk mengunduh file proposal
                        $encodedProposal = base64_encode($prestasi['file_proposal']);
                        $downloadUrl = 'data:application/pdf;base64,' . $encodedProposal;

                        // Menggunakan nama lomba sebagai nama file untuk diunduh
                        $downloadFilename = 'Proposal_' . $prestasi['NIM'] . '-' . $prestasi['nama_lomba'] . '.pdf';
                        ?>
                        <a style="text-align: right; display: block;" href="<?php echo $downloadUrl; ?>"
                            download="<?php echo $downloadFilename; ?>">
                            Download Proposal
                        </a>
                        <?php
                    } else {
                        echo '<span id="noProposal" style="text-align: left; display: block;">Tidak ada proposal</span><br>';
                    }
                    ?>
                </div>
            </div>

            <br><br>
            <div class="row message-box">
                <p><strong>Pesan dari Admin:</strong></p>
                <div class="message">
                    <?php
                    if ($prestasi['message'] != '') {
                        echo "<p>" . $prestasi['message'] . "</p>";
                    } else {
                        echo '<span id="noProposal" style="text-align: left; display: block;">Tidak ada Pesan</span>';
                    }

                    if ($_SESSION['level'] == 'admin') {
                        ?>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-success ms-auto" data-bs-toggle="modal"
                                data-bs-target="#editMessageModal"><i class="fa fa-edit"></i> Edit</button>
                        </div>

                        <!-- Modal Edit Pesan -->
                        <div class="modal fade" id="editMessageModal" tabindex="-1" aria-labelledby="editMessageModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editMessageModalLabel">Edit Pesan untuk Mahasiswa</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="updateMessage" action="action/prestasi_action.php" method="POST">
                                            <input type="hidden" name="action" id="action" value="editPesan">
                                            <input type="hidden" name="prestasiId" value="<?= $prestasi['id'] ?>">
                                            <div class="mb-3">
                                                <label for="message" class="form-label">Pesan</label>
                                                <textarea class="form-control" id="message" name="message" rows="4"
                                                    placeholder="Masukkan Pesan"><?php echo $prestasi['message']; ?></textarea>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-between">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="button" class="btn btn-primary"
                                            onclick="document.getElementById('updateMessage').submit();">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                    ?>


                </div>
            </div><br><br>
            <?php
            if ($_SESSION['level'] == 'admin') {
                ?>
                <div class="d-flex justify-content-center">
                    <!-- Tombol Verifikasi -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verifikasiModal">
                        Verifikasi Prestasi
                    </button>
                </div>

                <!-- Modal Konfirmasi -->
                <div class="modal fade" id="verifikasiModal" tabindex="-1" aria-labelledby="verifikasiModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="verifikasiModalLabel">Verifikasi Data Prestasi Ini</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="formVerifikasi" action="action/prestasi_action.php" method="POST">
                                    <input type="hidden" name="action" id="action" value="updateValidasi">
                                    <input type="hidden" name="prestasiId" value="<?= $prestasi['id'] ?>">

                                    <label class="form-label">Verifikasi Prestasi <span style="color: red;">*</span></label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="statusVerifikasi" id="valid"
                                            value="valid" <?php if($prestasi['status_verifikasi'] == 'waiting' || $prestasi['status_verifikasi'] == 'valid'){echo 'checked';} ?> required>
                                        <label class="form-check-label" for="valid">
                                            Valid
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="statusVerifikasi" id="invalid"
                                            value="invalid" <?php if($prestasi['status_verifikasi'] == 'invalid'){echo 'checked';} ?> required>
                                        <label class="form-check-label" for="invalid">
                                            Invalid
                                        </label>
                                    </div>

                                    <br>
                                    <label for="message" class="form-label">Pesan Untuk Mahasiswa</label>
                                    <label for="message" class="form-label">Pesan Untuk Mahasiswa</label>
                                    <textarea class="form-control" id="message" name="message" placeholder="Masukkan Pesan"
                                        rows="3"><?= $prestasi['message'] ?></textarea>
                                </form>
                            </div>
                            <div class="modal-footer d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="button" class="btn btn-primary"
                                    onclick="document.getElementById('formVerifikasi').submit();">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>






            <br><br>
            <?php
            if ($_SESSION['level'] != 'dosen') {
                ?>
                <div class="d-flex justify-content-between">
                    <!-- Tombol untuk membuka modal -->
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"
                        data-id="<?= $prestasi['id'] ?>">
                        Hapus
                    </button>

                    <form action="index.php?page=editprestasi" method="POST" style="display:inline;">
                        <input type="hidden" name="idPrestasi" value="<?= $prestasi['id'] ?>">
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </form>
                </div><br>
                <?php
            }
            ?>



        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Konfirmasi Penghapusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus prestasi ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" action="action/prestasi_action.php" method="POST">
                        <input type="hidden" name="action" id="action" value="delete">
                        <input type="hidden" name="prestasiId" id="prestasiId" value="">
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal khusus untuk foto -->
<div class="modal fade" id="fotoModal" tabindex="-1" aria-labelledby="fotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fotoModalLabel">Detail Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalFoto" src="" alt="Gambar Detail" class="img-fluid">
            </div>
        </div>
    </div>
</div>





<style>
    .table td {
        padding: 8px 12px;
        /* Menambahkan padding antar elemen */
    }

    .dark-mode table {
        color: white;
    }

    .table td.colon {
        width: auto;
        text-align: center;
        padding: 0 8px;
        /* Memberikan spasi horizontal */
    }

    .table td.text-nowrap {
        white-space: nowrap;
        /* Pastikan teks tidak terpotong */
    }

    .foto-box img {
        max-width: 100%;
        height: auto;
        display: block;
    }

    #noFoto,
    #noProposal,
    #noMessage {
        color: #999;
        font-style: italic;
    }

    #fotoModal .modal-body.text-center {
        background-color: white;
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    .dark-mode #fotoModal .modal-body.text-center {
        background-color: #364e5e;
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    #fotoModal .modal-dialog {
        max-width: 70%;
        width: auto;
        height: 60vh;
        margin: 0 auto;
    }

    #fotoModal .modal-content {
        height: 90%;
    }

    #fotoModal .modal-content .modal-body {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #fotoModal .modal-content img {
        height: 100%;
        width: auto;
        object-fit: contain;
        display: block;
        margin: 0 auto;
    }

    @media (max-width: 720px) {
        #fotoModal .modal-dialog {
            max-width: 95%;
            height: 20vh;
            margin: 0 auto;
        }

        #fotoModal .modal-content {
            height: 90%;
        }


        #fotoModal .modal-content .modal-body {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #fotoModal .modal-content img {
            width: 100%;
            height: auto;
            object-fit: contain;
            margin: 0 auto;
        }
    }

    .dark-mode textarea.form-control {
        background-color: #355470;
        color: white;
    }
    .dark-mode textarea.form-control:focus {
        background-color: #355470;
        color: white;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const modalFoto = document.getElementById("modalFoto");
        const modalTitle = document.getElementById("fotoModalLabel");
        const fotoTriggers = document.querySelectorAll(".foto-modal-trigger");

        fotoTriggers.forEach((foto) => {
            foto.addEventListener("click", function () {
                modalFoto.src = this.src; // Setel sumber gambar modal
                modalTitle.textContent = this.getAttribute("data-title"); // Perbarui judul modal
                const modal = new bootstrap.Modal(document.getElementById("fotoModal"));
                modal.show(); // Tampilkan modal
            });
        });
    });


    // Ambil elemen modal
    const confirmDeleteModal = document.getElementById('confirmDeleteModal');

    // Tambahkan event listener ketika modal ditampilkan
    confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
        // Tombol yang memicu modal
        const button = event.relatedTarget;

        // Ambil data-id dari tombol
        const prestasiId = button.getAttribute('data-id');

        // Set nilai input hidden di form
        const inputPrestasiId = confirmDeleteModal.querySelector('#prestasiId');
        inputPrestasiId.value = prestasiId;
    });

    // Fungsi untuk menyembunyikan alert setelah 5 detik
    setTimeout(function () {
        let successAlert = document.getElementById('success-alert');
        let errorAlert = document.getElementById('error-alert');
        if (successAlert) {
            successAlert.style.transition = 'opacity 0.5s';
            successAlert.style.opacity = '0';
            setTimeout(() => successAlert.remove(), 500); // Hapus elemen setelah transisi selesai
        }
        if (errorAlert) {
            errorAlert.style.transition = 'opacity 0.5s';
            errorAlert.style.opacity = '0';
            setTimeout(() => errorAlert.remove(), 500); // Hapus elemen setelah transisi selesai
        }
    }, 3000); // Waktu tunggu 5 detik
</script>