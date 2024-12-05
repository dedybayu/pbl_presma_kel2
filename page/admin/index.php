<!-- Content Area -->
<div class="content">
    <div class="kotak-judul">
        <p>SELAMAT DATANG DI SISTEM PENCATATAN PRESTASI MAHASISWA</p>
    </div><br>
    <?php
    require_once 'model/PrestasiModel.php';
    $prestasiModel = new PrestasiModel();
    $prestasi = $prestasiModel->getTopAllPrestasi();
    ?>
    <div class="kotak-konten">
        <div class="container">
            <h1 class="mb-4">Prestasi Terbaik Mahasiswa</h1>
            <?php
            if ($prestasi != null) {
                ?>
                <div class="row g-4">
                    <!-- Sertifikat -->
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

                    <!-- Informasi Lomba -->
                    <div class="col-12 col-md-6 box-transparen">
                        <table class="table table-borderless align-middle">
                            <tbody>
                                <tr>
                                    <td class="text-nowrap"><strong>Nama Mahasiswa</strong></td>
                                    <td class="colon">:</td>
                                    <td><strong><?= $prestasi['nama_mhs']; ?></strong></td>
                                </tr>
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
                </div>
                <?php
            }
            ?>

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
        margin: 0 auto;
    }
</style>