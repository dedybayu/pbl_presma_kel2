<!-- Tampilan List Prestasi -->
<?php
require_once "model/PrestasiModel.php";
$listPrestasi = new PrestasiModel();
$daftarPrestasi = $listPrestasi->getListPrestasi($_SESSION['nim']);
?>

<!-- Content Area -->
<div class="content">


    <div class="kotak-judul">
        <p>Daftar Prestasi <?php echo $row['nama']; ?></p>
    </div>

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
    <style>
        .alert-delete {
            max-width: 70%;
            margin: 0 auto;
            text-align: center;
        }
    </style>
    <div class="kotak-konten">

        <?php
        if (empty($daftarPrestasi)) {
            ?>

            <div class="container">
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
            <div class="table-container">
                <br>
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Juara</th>
                            <th>Tingkat</th>
                            <th>Tanggal</th>
                            <th>Penyelenggara</th>
                            <th>Poin</th>
                            <th>Upload Date</th>
                            <th>Status Verifikasi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($daftarPrestasi as $prestasi) {
                            // $modal_prestasi = $prestasi;
                            echo "<tr>";
                            echo "<td>" . $prestasi['nama_lomba'] . "</td>";
                            echo "<td>" . "Juara " . $prestasi['juara_lomba'] . "</td>";
                            echo "<td>" . $prestasi['tingkat_lomba'] . "</td>";
                            echo "<td>" . $prestasi['waktu_pelaksanaan'] . "</td>";
                            echo "<td>" . $prestasi['penyelenggara_lomba'] . "</td>";
                            echo "<td>" . $prestasi['poin'] . "</td>";
                            echo "<td>" . $prestasi['upload_date']->format('d-m-Y H:i') . "</td>";
                            echo "<td>" . $prestasi['status_verifikasi'] . "</td>";
                            ?>
                            <td style="text-align: center; vertical-align: middle;">
                                <!-- Button untuk menampilkan ID -->
                                <a class="btn btn-success btn-sm btn-detail"
                                    href="index.php?page=detailprestasi&idPrestasi=<?php echo $prestasi['id']; ?>">
                                    <i class="fa fa-edit"></i> Detail
                                </a>

                            </td>
                            <?php
                            echo "</tr>";

                            // Modal for each prestasi
                            ?>

                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php
        }
        ?>

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
    }, 3000);// Waktu tunggu 5 detik
</script>