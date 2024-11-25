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
    </div>
    <?php
    if (isset($_SESSION['success_message'])) {
        echo '<div id="success-alert" class="alert alert-success text-center" role="alert">';
        echo $_SESSION['success_message'];
        echo '</div>';
        unset($_SESSION['success_message']); // Hapus pesan setelah ditampilkan
    }

    if (isset($_SESSION['error_message'])) {
        echo '<div id="error-alert" class="alert alert-danger text-center" role="alert">';
        echo $_SESSION['error_message'];
        echo '</div>';
        unset($_SESSION['error_message']); // Hapus pesan setelah ditampilkan
    }
    ?>

    <div class="container my-4">
        <div class="table-container">
            <?php
            if (empty($daftarPrestasi)) {
                ?>
                <div class="kotak-konten">
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
                <br>
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
                                            <h5 class="modal-title" id="detailModalLabel_<?php echo $prestasi['id']; ?>">
                                                Detail
                                                Prestasi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>ID Lomba:</strong> <?php echo $prestasi['id']; ?></p>
                                            <p><strong>Nama Lomba:</strong> <?php echo $prestasi['nama_lomba']; ?></p>
                                            <p><strong>Juara:</strong> <?php echo "Juara " . $prestasi['juara_lomba']; ?>
                                            </p>
                                            <p><strong>Tingkat:</strong> <?php echo $prestasi['tingkat_lomba']; ?></p>
                                            <p><strong>Tanggal:</strong> <?php echo $prestasi['waktu_pelaksanaan']; ?></p>
                                            <p><strong>Penyelenggara:</strong>
                                                <?php echo $prestasi['penyelenggara_lomba']; ?>
                                            </p>

                                            <!-- Menampilkan Sertifikat jika ada -->
                                            <p><strong>Sertifikat:</strong></p>
                                            <div id="modalFotoContainer_<?php echo $prestasi['id']; ?>">
                                                <?php
                                                if (!empty($prestasi['file_sertifikat'])) {
                                                    echo '<img id="modalFoto" src="data:image/jpeg;base64,' . base64_encode($prestasi['file_sertifikat']) . '" alt="Sertifikat" class="img-fluid">';
                                                } else {
                                                    echo '<span id="noFoto">Tidak ada foto</span>';
                                                }
                                                ?>
                                            </div>

                                            <br>

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
                                                    // Tampilkan PDF menggunakan <embed>
                                                    echo '<embed id="modalProposal" src="data:application/pdf;base64,' . base64_encode($prestasi['file_proposal']) . '" width="100%" height="600px">';

                                                    // Tautan untuk mengunduh file proposal
                                                    $encodedProposal = base64_encode($prestasi['file_proposal']);
                                                    $downloadUrl = 'data:application/pdf;base64,' . $encodedProposal;
                                                    ?>
                                                    <a style="text-align: right; display: block;" href="<?php echo $downloadUrl; ?>"
                                                        download="proposal_<?php echo $prestasi['id']; ?>.pdf">
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
                                                    data-bs-target="#confirmDeleteModal"
                                                    data-id="<?php echo $prestasi['id']; ?>">
                                                    Hapus
                                                </button>

                                                <a href="index.php?page=editprestasi&idPrestasi=<?php echo $prestasi['id']; ?>"
                                                    class="btn btn-primary">Edit</a>
                                            </div><br>
                                        </div>
                                        <div class="modal-footer">

                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Tutup</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            }
            ?>

        </div>
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
                <form id="deleteForm" action="fungsi/hapus_prestasi.php" method="POST">
                    <input type="hidden" name="prestasiId" id="prestasiId" value="">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>


<style>
    /* Modal style untuk detailModal */
    #confirmDeleteModal .modal-dialog {
        max-width: 550px;
    }

    .modal-dialog {
        max-width: 1300px;
        height: 90%;
        max-height: 95%;
        margin-left: auto;
        margin-right: auto;
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

    .modal-body {
        max-height: 70vh;
        overflow-y: auto;
    }

    @media (max-width: 1100px) {
        .modal-dialog {
            width: 90%;
        }

        #modalFoto {
            width: 95%;
        }

    }

    @media (min-width: 1101px) {
        #modalFoto {
            width: 75%;
        }
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

<script>
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