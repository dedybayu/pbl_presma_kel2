<!-- Content Area -->
<div class="content">

    <!-- Tampilan List Dosen -->
    <?php
    require_once "model/PrestasiModel.php";
    require_once "class_data/data_user.php";

    $prestasiModel = new PrestasiModel();
    $prestasi = $prestasiModel->getPrestasiById($_GET['idPrestasi']);
    function getListDosen($prestasi)
    {
        $listDosen = new ListDosen();
        $dosenList = $listDosen->getListDosen();
        $nipDosbimPrestasi = $prestasi['nip_dosbim'];
        if (!empty($dosenList)) {
            foreach ($dosenList as $dosen) {
                $selected = ($nipDosbimPrestasi === $dosen['nip']) ? 'selected' : '';
                echo "<option value='" . $dosen['nip'] . "' $selected>- " . htmlspecialchars($dosen['nama']) . "</option>";
            }
        } else {
            echo "Tidak ada dosen yang ditemukan.";
        }
    }


    ?>

    <div class="kotak-judul">
        <p>Edit Prestasi</p>
    </div>

    <div class="kotak-konten">
        <div class="container">
            <h1 class="mb-4">Edit Prestasi <?php echo $prestasi['nama_lomba']; ?></h1>
            <form action="../action/prestasi_action.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" id="action" value="update">
                <input type="hidden" name="idPrestasi" id="idPrestasi" value="<?php echo $_GET['idPrestasi'] ?>">
                <input type="hidden" name="nim" id="nim" value="<?php echo $_SESSION['nim'] ?>">
                <!-- Nama Lomba -->
                <div class="mb-3">
                    <label for="namaLomba" class="form-label">Nama Lomba <span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="namaLomba" name="nama_lomba"
                        value="<?php echo $prestasi['nama_lomba']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="tingkatLomba" class="form-label">Tingkatan Lomba <span
                            style="color: red;">*</span></label>
                    <select class="form-select" id="tingkatLomba" name="tingkat_lomba" required>
                        <option value="" disabled selected>Pilih Tingkatan</option>
                        <option value="internasional" <?php if ($prestasi['tingkat_lomba'] === 'internasional') {
                            echo 'selected';
                        } ?>>Internasional
                        </option>
                        <option value="nasional" <?php if ($prestasi['tingkat_lomba'] === 'nasional') {
                            echo 'selected';
                        } ?>>Nasional</option>
                        <option value="regional" <?php if ($prestasi['tingkat_lomba'] === 'regional') {
                            echo 'selected';
                        } ?>>Regional</option>
                    </select>
                </div>

                <!-- Juara Lomba -->
                <div class="mb-3">
                    <label for="juaraLomba" class="form-label">Juara Lomba <span style="color: red;">*</span></label>
                    <select class="form-select" id="juaraLomba" name="juara_lomba" required>
                        <option value="" disabled selected>Pilih Juara</option>
                        <option value="1" <?php if ($prestasi['juara_lomba'] === '1') {
                            echo 'selected';
                        } ?>>Juara 1
                        </option>
                        <option value="2" <?php if ($prestasi['juara_lomba'] === '2') {
                            echo 'selected';
                        } ?>>Juara 2
                        </option>
                        <option value="3" <?php if ($prestasi['juara_lomba'] === '3') {
                            echo 'selected';
                        } ?>>Juara 3
                        </option>
                        <option value="lainnya" <?php if ($prestasi['juara_lomba'] === 'lainnya') {
                            echo 'selected';
                        } ?>>Kategori Lain</option>
                    </select>
                </div>

                <!-- Jenis Lomba -->
                <div class="mb-3">
                    <label for="jenisLomba" class="form-label">Jenis Lomba <span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="jenisLomba" name="jenis_lomba"
                        value="<?php echo $prestasi['jenis_lomba']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="penyelenggaraLomba" class="form-label">Penyelenggara Lomba <span
                            style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="penyelenggaraLomba" name="penyelenggara_lomba"
                        value="<?php echo $prestasi['penyelenggara_lomba']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="dosenPembimbing" class="form-label">Dosen Pembimbing</label>
                    <select class="form-select" id="DosenPembimbig" name="dosbim">
                        <option value="" disabled selected>Pilih Dosen</option>
                        <?php getListDosen($prestasi); ?>
                    </select>
                </div>

                <?php
                // Pastikan waktu_pelaksanaan adalah objek DateTime
                $waktuPelaksanaan = $prestasi['waktu_pelaksanaan'];

                // Jika $waktuPelaksanaan sudah berupa objek DateTime, kita bisa langsung menggunakan format()
                if ($waktuPelaksanaan instanceof DateTime) {
                    $waktuPelaksanaan = $waktuPelaksanaan->format('Y-m-d');
                }
                ?>

                <div class="mb-3">
                    <label for="waktuLomba" class="form-label">Waktu Pelaksanaan <span
                            style="color: red;">*</span></label>
                    <input type="date" class="form-control" id="waktuLomba" name="waktu_lomba"
                        value="<?php echo $waktuPelaksanaan; ?>" required>
                </div>


                <div class="mb-3">
                    <label for="tempatLomba" class="form-label">Tempat Pelaksanaan <span
                            style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="tempatLomba" name="tempat_lomba"
                        value="<?php echo $prestasi['tempat_pelaksanaan']; ?>" required>
                </div>

                <p><strong>Sertifikat:</strong></p>
                <div id="modalFotoContainer">
                    <?php
                    if (!empty($prestasi['file_sertifikat'])) {
                        echo '<img id="modalFoto" src="data:image/jpeg;base64,' . base64_encode($prestasi['file_sertifikat']) . '" alt="Sertifikat" class="img-fluid">';
                    } else {
                        echo '<span id="noFoto">Tidak ada foto</span>';
                    }
                    ?>
                </div>

                <!-- Sertifikat -->
                <div class="mb-3">
                    <label for="sertifikat" class="form-label">Sertifikat <span style="color: red;">*</span></label>
                    <input type="file" class="form-control" id="sertifikat" name="sertifikat" accept="image/*">
                    <small class="text-muted">Maksimal ukuran file: 1MB</small>
                </div><br>

                <!-- Menampilkan foto jika ada -->
                <p><strong>Bukti Foto:</strong></p>
                <div id="modalFotoContainer">
                    <?php
                    if (!empty($prestasi['file_bukti_foto'])) {
                        echo '<img id="modalFoto" src="data:image/jpeg;base64,' . base64_encode($prestasi['file_bukti_foto']) . '" alt="Foto Prestasi" class="img-fluid">';
                    } else {
                        echo '<span id="noFoto">Tidak ada foto</span>';
                    }
                    ?>
                </div>
                <div class="mb-3">
                    <label for="fotoLomba" class="form-label">Foto Saat Perlombaan <span
                            style="color: red;">*</span></label>
                    <input type="file" class="form-control" id="fotoLomba" name="foto_lomba" accept="image/*">
                    <small class="text-muted">Maksimal ukuran file: 1MB</small>
                </div><br>

                <p><strong>Surat Undangan:</strong></p>
                <div id="modalFotoContainer">
                    <?php
                    if (!empty($prestasi['file_surat_undangan'])) {
                        echo '<img id="modalFoto" src="data:image/jpeg;base64,' . base64_encode($prestasi['file_surat_undangan']) . '" alt="Foto Surat Undangan" class="img-fluid">';
                    } else {
                        echo '<span id="noFoto">Tidak ada surat undangan</span>';
                    }
                    ?>
                </div>

                <div class="mb-3">
                    <label for="suratUndangan" class="form-label">Surat Undangan</label>
                    <input type="file" class="form-control" id="suratUndangan" name="surat_undangan" accept="image/*">
                    <small class="text-muted">Maksimal ukuran file: 1MB</small>
                </div>
                <br>

                <p><strong>Surat Tugas:</strong></p>
                <div id="modalFotoContainer">
                    <?php
                    if (!empty($prestasi['file_surat_tugas'])) {
                        echo '<img id="modalFoto" src="data:image/jpeg;base64,' . base64_encode($prestasi['file_surat_tugas']) . '" alt="Foto Surat Undangan" class="img-fluid">';
                    } else {
                        echo '<span id="noFoto">Tidak ada surat undangan</span>';
                    }
                    ?>
                </div>

                <div class="mb-3">
                    <label for="suratTugas" class="form-label">Surat Tugas</label>
                    <input type="file" class="form-control" id="suratTugas" name="surat_tugas" accept="image/*">
                    <small class="text-muted">Maksimal ukuran file: 1MB</small>
                </div><br>

                <p>Proposal Sebelumnya:</p>
                <div>
                    <?php
                    if (!empty($prestasi['file_proposal'])) {
                        // Tampilkan PDF menggunakan <embed>
                        echo '<embed id="pdfProposal" src="data:application/pdf;base64,' . base64_encode($prestasi['file_proposal']) . '"  width="100%" >';

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

                <div class="mb-3">
                    <label for="proposal" class="form-label">Ubah Proposal</label>
                    <input type="file" class="form-control" id="proposal" name="proposal" accept="application/pdf">
                    <small class="text-muted">Maksimal ukuran file: 4MB. Hanya file PDF yang diperbolehkan.</small>
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-between">
                    <!-- Tombol Batal -->
                    <a href="index.php?page=daftarprestasi" class="btn btn-secondary">Batal</a>
                    <!-- Tombol Submit -->
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </form><br>
        </div>

    </div>

    <style>
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



        .kotak-konten {
            max-height: 80vh;
            overflow-y: auto;
        }


        @media (max-width: 1100px) {


            #modalFoto {
                width: 95%;
            }

            #modalProposal {
                width: 100%;
            }

        }

        @media (min-width: 1101px) {
            #modalFoto {
                width: 75%;
            }

            #modalProposal {
                width: 80%;
            }
        }



        .dark-mode #modalFoto {
            border: 5px solid #528fad;
            /* Menambahkan border dengan warna hitam */
        }


        #modalProposal {

            height: 600px;
        }

        /* Modal style untuk modal foto */
        .kotak-konten #modalFotoContainer img {
            width: 100%;
            max-width: 800px;
            border-radius: 8px;
            border: 3px solid #ccc;
        }

        /* Styling the 'Tidak ada foto' message */
        .kotak-konten #noFoto,
        .kotak-konten #noProposal {
            color: #999;
            font-style: italic;
        }

        /* Default: Tinggi 50% dari layar */
        #pdfProposal {
            height: 50vh;
            /* 50% dari tinggi layar */
        }

        /* Untuk layar lebar: Tinggi 80% dari layar */
        @media (min-width: 1024px) {
            #pdfProposal {
                height: 70vh;
                /* 80% dari tinggi layar */
            }
        }
    </style>


    <script>
        document.querySelector('form').addEventListener('submit', function (event) {
            const MAX_IMAGE_SIZE = 1 * 1024 * 1024; // 1MB untuk file gambar
            const MAX_PDF_SIZE = 4 * 1024 * 1024; // 4MB untuk file PDF
            let isValid = true;

            // Bersihkan pesan error sebelumnya
            document.querySelectorAll('.error-message').forEach(el => el.remove());

            // Ambil elemen file
            const sertifikat = document.getElementById('sertifikat').files[0];
            const fotoLomba = document.getElementById('fotoLomba').files[0];
            const suratUndangan = document.getElementById('suratUndangan').files[0];
            const suratTugas = document.getElementById('suratTugas').files[0];
            const proposal = document.getElementById('proposal').files[0];

            // Fungsi untuk menampilkan pesan error
            const showError = (element, message) => {
                const errorMessage = document.createElement('div');
                errorMessage.className = 'error-message text-danger';
                errorMessage.textContent = message;
                element.parentElement.appendChild(errorMessage);
            };

            // Validasi ukuran gambar
            [sertifikat, fotoLomba, suratUndangan, suratTugas].forEach((file, index) => {
                if (file && file.size > MAX_IMAGE_SIZE) {
                    showError(document.querySelectorAll('input[type="file"]')[index],
                        `File ${file.name} melebihi ukuran maksimal 1MB.`);
                    isValid = false;
                }
            });

            // Validasi ukuran proposal (PDF)
            if (proposal && proposal.size > MAX_PDF_SIZE) {
                showError(document.getElementById('proposal'),
                    `File ${proposal.name} melebihi ukuran maksimal 4MB.`);
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault(); // Batalkan pengiriman formulir
            }
        });
    </script>

</div>