<div class="content">
    <!-- Tampilan List Prestasi -->
    <?php
    require_once "model/PrestasiModel.php";
    $prestasiModel = new PrestasiModel();
    $prestasi = $prestasiModel->getPrestasiById($_GET['idPrestasi']);
    ?>

    <div class="kotak-judul d-flex align-items-center justify-content-between" style="padding-bottom: 15px">
        <a type="button" href="index.php?page=daftarprestasi" class="btn btn-primary"> Kembali </a>
        <p class="mb-0 flex-grow-1 text-center">Detail Prestasi</p>
    </div>




    <div class="kotak-konten">
        <div class="container">
            <p><strong>ID Lomba:</strong> <?php echo $prestasi['id']; ?></p>
            <p><strong>Nama Lomba:</strong> <?php echo $prestasi['nama_lomba']; ?></p>
            <p><strong>Juara:</strong> <?php echo "Juara " . $prestasi['juara_lomba']; ?>
            </p>
            <p><strong>Tingkat:</strong> <?php echo $prestasi['tingkat_lomba']; ?></p>
            <p><strong>Tanggal:</strong> <?php echo $prestasi['waktu_pelaksanaan']->format('j F Y'); ?></p>
            <p><strong>Penyelenggara:</strong>
                <?php echo $prestasi['penyelenggara_lomba']; ?>
            </p>

            <!-- Menampilkan Sertifikat jika ada -->
            <p><strong>Sertifikat:</strong></p>
            <div id="FotoContainer">
                <?php
                if (!empty($prestasi['file_sertifikat'])) {
                    echo '<img id="foto" src="data:image/jpeg;base64,' . base64_encode($prestasi['file_sertifikat']) . '" alt="Sertifikat" class="img-fluid">';
                } else {
                    echo '<span id="noFoto">Tidak ada foto</span>';
                }
                ?>
            </div>

            <br>

            <!-- Menampilkan foto jika ada -->
            <p><strong>Bukti Foto:</strong></p>
            <div id="FotoContainer">
                <?php
                if (!empty($prestasi['file_bukti_foto'])) {
                    echo '<img id="foto" src="data:image/jpeg;base64,' . base64_encode($prestasi['file_bukti_foto']) . '" alt="Foto Prestasi" class="img-fluid">';
                } else {
                    echo '<span id="noFoto">Tidak ada foto</span>';
                }
                ?>
            </div>

            <br>

            <p><strong>Surat Undangan:</strong></p>
            <div id="FotoContainer">
                <?php
                if (!empty($prestasi['file_surat_undangan'])) {
                    echo '<img id="foto" src="data:image/jpeg;base64,' . base64_encode($prestasi['file_surat_undangan']) . '" alt="Foto Surat Undangan" class="img-fluid">';
                } else {
                    echo '<span id="noFoto">Tidak ada surat undangan</span>';
                }
                ?>
            </div>

            <br>

            <p><strong>Surat Tugas:</strong></p>
            <div id="FotoContainer">
                <?php
                if (!empty($prestasi['file_surat_tugas'])) {
                    echo '<img id="foto" src="data:image/jpeg;base64,' . base64_encode($prestasi['file_surat_tugas']) . '" alt="Foto Surat Undangan" class="img-fluid">';
                } else {
                    echo '<span id="noFoto">Tidak ada surat undangan</span>';
                }
                ?>
            </div>

            <br>

            <!-- Menampilkan proposal jika ada -->
            <p><strong>Proposal:</strong></p>
            <div id="ProposalContainer" class="text-center">
                <?php
                if (!empty($prestasi['file_proposal'])) {
                    // Tampilkan PDF menggunakan <embed>
                    echo '<embed id="Proposal" src="data:application/pdf;base64,' . base64_encode($prestasi['file_proposal']) . '" width="100%" height="600px">';

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
                    echo '<span id="noProposal" style="text-align: left; display: block;">Tidak ada proposal</span>';
                }
                ?>
            </div>

            <br>

            <p><strong>Message:</strong></p>
            <div class="message-box">
                <p>aaaaaaaaaaaaa</p>
                <p>aaaaaaaaaaaaa</p>
                <p>aaaaaaaaaaaaa</p>
            </div>

            <br><br>

            <div class="d-flex justify-content-between">
                <!-- Tombol untuk membuka modal -->
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"
                    data-id="<?php echo $prestasi['id']; ?>">
                    Hapus
                </button>

                <a href="index.php?page=editprestasi&idPrestasi=<?php echo $prestasi['id']; ?>"
                    class="btn btn-primary">Edit</a>
            </div><br>
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





<style>
    .message-box {
        width: 100%;

        padding: 10px;
        /* Jarak dalam kotak */
        background-color: #f9f9f9;
        /* Warna latar belakang kotak */
        border: 1px solid #ccc;
        /* Warna dan ketebalan border */
        border-radius: 5px;
        /* Membuat sudut kotak melengkung */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        /* Efek bayangan */
        font-family: Arial, sans-serif;
        /* Font yang digunakan */
        color: #333;
        /* Warna teks */
    }






    .kotak-konten {
        max-height: 80vh;
        overflow-y: auto;
    }


    @media (max-width: 1100px) {


        #foto {
            width: 95%;
        }

        #modalProposal {
            width: 100%;
        }

    }

    @media (min-width: 1101px) {
        #foto {
            width: 75%;
        }

        #modalProposal {
            width: 100%;
        }
    }

    
    .kotak-konten .container #ProposalContainer embed {
        border: 5px solid #007bff; 

    }

    .dark-mode .kotak-konten .container #ProposalContainer embed {
        border: 5px solid #528fad;

    }



    .dark-mode .kotak-konten .container #FotoContainer img {
        border: 5px solid #528fad;
        /* Menambahkan border dengan warna hitam */
    }


    .container #modalProposal {
        height: 600px;
    }

    /* Modal style untuk modal foto */
    .kotak-konten .container #FotoContainer img {
        height: auto; /* Menjaga proporsi tinggi */
    display: block; /* Menampilkan sebagai blok */
    margin: auto;
        width: 100%;
        max-width: 800px;
        border-radius: 8px;
        border: 5px solid #007bff; /* Mengubah warna border menjadi biru */
    }

    /* Styling the 'Tidak ada foto' message */
    .kotak-konten .container #noFoto,
    .kotak-konten .container #noProposal {
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