<!-- Content Area -->
<div class="content">

    <!-- Tampilan List Dosen -->
    <?php
    require_once "class_data/data_user.php";
    function getListDosen()
    {
        $listDosen = new ListDosen();
        $dosenList = $listDosen->getListDosen();
        if (!empty($dosenList)) {
            foreach ($dosenList as $dosen) {
                echo "<option value='" . $dosen['nip'] . "'>- " . htmlspecialchars($dosen['nama']) . "</option>";
            }
        } else {
            echo "Tidak ada dosen yang ditemukan.";
        }
    }
    ?>

    <div class="kotak-judul">
        <p>Input Prestasi</p>
    </div>

    <div class="kotak-konten">
        <div class="container">
            <h1 class="mb-4">Masukan Prestasimu Disini</h1>
            <hr><br>
            <form action="action/prestasi_action.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" id="action" value="add">
                <input type="hidden" name="nim" id="nim" value="<?php echo $_SESSION['nim'] ?>">

                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <!-- Nama Lomba -->
                        <div class="mb-3">
                            <label for="namaLomba" class="form-label">Nama Lomba <span
                                    style="color: red;">*</span></label>
                            <input type="text" class="form-control" id="namaLomba" name="nama_lomba" required>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="tingkatLomba" class="form-label">Tingkatan Lomba <span
                                    style="color: red;">*</span></label>
                            <select class="form-select" id="tingkatLomba" name="tingkat_lomba" required>
                                <option value="" disabled selected>Pilih Tingkatan</option>
                                <option value="internasional">Internasional</option>
                                <option value="nasional">Nasional</option>
                                <option value="regional">Regional</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="statusTim" class="form-label">Individu/Tim?<span
                                    style="color: red;">*</span></label>
                            <select class="form-select" id="statusTim" name="status_tim" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                <option value="tim">Tim</option>
                                <option value="individu">Individu</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <!-- Juara Lomba -->
                        <div class="mb-3">
                            <label for="juaraLomba" class="form-label">Juara Lomba <span
                                    style="color: red;">*</span></label>
                            <select class="form-select" id="juaraLomba" name="juara_lomba" required>
                                <option value="" disabled selected>Pilih Juara</option>
                                <option value="1">Juara 1</option>
                                <option value="2">Juara 2</option>
                                <option value="3">Juara 3</option>
                                <option value="lainnya">Kategori Lain</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <!-- Jenis Lomba -->
                        <div class="mb-3">
                            <label for="jenisLomba" class="form-label">Jenis Lomba <span
                                    style="color: red;">*</span></label>
                            <input type="text" class="form-control" id="jenisLomba" name="jenis_lomba" required>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="penyelenggaraLomba" class="form-label">Penyelenggara Lomba <span
                                    style="color: red;">*</span></label>
                            <input type="text" class="form-control" id="penyelenggaraLomba" name="penyelenggara_lomba"
                                required>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="dosenPembimbing" class="form-label">Dosen Pembimbing<span 
                                    style="color: red;">*</span></label>
                            <select class="form-select" id="DosenPembimbig" name="dosbim" required>
                                <option value="" disabled selected>Pilih Dosen</option>
                                <?php getListDosen(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="waktuLomba" class="form-label">Waktu Pelaksanaan <span
                                    style="color: red;">*</span></label>
                            <input type="date" class="form-control" id="waktuLomba" name="waktu_lomba" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="tempatLomba" class="form-label">Tempat Pelaksanaan <span
                                    style="color: red;">*</span></label>
                            <input type="text" class="form-control" id="tempatLomba" name="tempat_lomba" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <!-- Sertifikat -->
                        <div class="mb-3">
                            <label for="sertifikat" class="form-label">Sertifikat <span
                                    style="color: red;">*</span></label>
                            <input type="file" class="form-control" id="sertifikat" name="sertifikat" accept="image/*"
                                required>
                            <small class="text-infoFile">Maksimal ukuran file: 1MB</small>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="fotoLomba" class="form-label">Foto Saat Perlombaan <span
                                    style="color: red;">*</span></label>
                            <input type="file" class="form-control" id="fotoLomba" name="foto_lomba" accept="image/*"
                                required>
                            <small class="text-infoFile">Maksimal ukuran file: 1MB</small>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="suratUndangan" class="form-label">Surat Undangan</label>
                            <input type="file" class="form-control" id="suratUndangan" name="surat_undangan"
                                accept="image/*">
                            <small class="text-infoFile">Maksimal ukuran file: 1MB</small>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="suratTugas" class="form-label">Surat Tugas</label>
                            <input type="file" class="form-control" id="suratTugas" name="surat_tugas" accept="image/*">
                            <small class="text-infoFile">Maksimal ukuran file: 1MB</small>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="proposal" class="form-label">Proposal</label>
                        <input type="file" class="form-control" id="proposal" name="proposal" accept="application/pdf">
                        <small class="text-infoFile">Maksimal ukuran file: 4MB. Hanya file PDF yang
                            diperbolehkan.</small>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-between">
                    <!-- Tombol Batal -->
                    <a href="index.php" class="btn btn-secondary">Batal</a>
                    <!-- Tombol Submit -->
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </form><br>
        </div>

    </div>

    <style>
        .dark-mode .form-control,
        .dark-mode .form-select {
            background-color: #355470;
            color: white;
        }

        /* Ganti warna placeholder di mode gelap */
        .dark-mode .form-control::placeholder,
        .dark-mode .form-select::placeholder {
            color: #aaa;
            /* Warna placeholder */
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