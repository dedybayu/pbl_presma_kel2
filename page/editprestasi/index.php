<!-- Content Area -->
<div class="content">

    <!-- Tampilan List Dosen -->
    <?php
    require_once "class_data/data_user.php";
    require_once "class_data/data_prestasi.php";
    $listPrestasi = new ListPrestasi();
    $daftarPrestasi = $listPrestasi->getPrestasiById($_GET['idPrestasi']);
    function getListDosen($prestasi)
    {
        $listDosen = new ListDosen();
        $dosenList = $listDosen->getListDosen();
        $nipDosbimPrestasi = $prestasi[0]['nip_dosbim'];
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
        <p>EDIT Prestasi</p>
    </div><br>

    <div class="kotak-konten">
        <div class="container">
            <h1 class="mb-4">Masukan Prestasimu Disini <?php echo $_GET['idPrestasi'] ?></h1>
            <form action="../fungsi/add_prestasi.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="idPrestasi" id="idPrestasi" value="<?php echo $_GET['idPrestasi'] ?>">
                <input type="hidden" name="nim" id="nim" value="<?php echo $_SESSION['nim'] ?>">
                <!-- Nama Lomba -->
                <div class="mb-3">
                    <label for="namaLomba" class="form-label">Nama Lomba <span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="namaLomba" name="nama_lomba"
                        value="<?php echo $daftarPrestasi[0]['nama_lomba']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="tingkatLomba" class="form-label">Tingkatan Lomba <span
                            style="color: red;">*</span></label>
                    <select class="form-select" id="tingkatLomba" name="tingkat_lomba" required>
                        <option value="" disabled selected>Pilih Tingkatan</option>
                        <option value="internasional" <?php if ($daftarPrestasi[0]['tingkat_lomba'] === 'internasional') {
                            echo 'selected';
                        } ?>>Internasional
                        </option>
                        <option value="nasional" <?php if ($daftarPrestasi[0]['tingkat_lomba'] === 'nasional') {
                            echo 'selected';
                        } ?>>Nasional</option>
                        <option value="regional" <?php if ($daftarPrestasi[0]['tingkat_lomba'] === 'regional') {
                            echo 'selected';
                        } ?>>Regional</option>
                    </select>
                </div>

                <!-- Juara Lomba -->
                <div class="mb-3">
                    <label for="juaraLomba" class="form-label">Juara Lomba <span style="color: red;">*</span></label>
                    <select class="form-select" id="juaraLomba" name="juara_lomba" required>
                        <option value="" disabled selected>Pilih Juara</option>
                        <option value="1" <?php if ($daftarPrestasi[0]['juara_lomba'] === '1') {
                            echo 'selected';
                        } ?>>Juara 1
                        </option>
                        <option value="2" <?php if ($daftarPrestasi[0]['juara_lomba'] === '2') {
                            echo 'selected';
                        } ?>>Juara 2
                        </option>
                        <option value="3" <?php if ($daftarPrestasi[0]['juara_lomba'] === '3') {
                            echo 'selected';
                        } ?>>Juara 3
                        </option>
                        <option value="lainnya" <?php if ($daftarPrestasi[0]['juara_lomba'] === 'lainnya') {
                            echo 'selected';
                        } ?>>Kategori Lain</option>
                    </select>
                </div>

                <!-- Jenis Lomba -->
                <div class="mb-3">
                    <label for="jenisLomba" class="form-label">Jenis Lomba <span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="jenisLomba" name="jenis_lomba"
                        value="<?php echo $daftarPrestasi[0]['jenis_lomba']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="penyelenggaraLomba" class="form-label">Penyelenggara Lomba <span
                            style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="penyelenggaraLomba" name="penyelenggara_lomba"
                        value="<?php echo $daftarPrestasi[0]['penyelenggara_lomba']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="dosenPembimbing" class="form-label">Dosen Pembimbing</label>
                    <select class="form-select" id="DosenPembimbig" name="dosbim">
                        <option value="" disabled selected>Pilih Dosen</option>
                        <?php getListDosen($daftarPrestasi); ?>
                    </select>
                </div>

                <?php
                // Pastikan waktu_pelaksanaan adalah objek DateTime
                $waktuPelaksanaan = $daftarPrestasi[0]['waktu_pelaksanaan'];

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
                    <input type="text" class="form-control" id="tempatLomba" name="tempat_lomba" value="<?php echo $daftarPrestasi[0]['tempat_pelaksanaan']; ?>" required>
                </div>

                <!-- Sertifikat -->
                <div class="mb-3">
                    <label for="sertifikat" class="form-label">Sertifikat <span style="color: red;">*</span></label>
                    <input type="file" class="form-control" id="sertifikat" name="sertifikat" accept="image/*">
                    <small class="text-muted">Maksimal ukuran file: 1MB</small>
                </div>

                <div class="mb-3">
                    <label for="fotoLomba" class="form-label">Foto Saat Perlombaan <span
                            style="color: red;">*</span></label>
                    <input type="file" class="form-control" id="fotoLomba" name="foto_lomba" accept="image/*">
                    <small class="text-muted">Maksimal ukuran file: 1MB</small>
                </div>

                <div class="mb-3">
                    <label for="suratUndangan" class="form-label">Surat Undangan</label>
                    <input type="file" class="form-control" id="suratUndangan" name="surat_undangan" accept="image/*">
                    <small class="text-muted">Maksimal ukuran file: 1MB</small>
                </div>

                <div class="mb-3">
                    <label for="suratTugas" class="form-label">Surat Tugas</label>
                    <input type="file" class="form-control" id="suratTugas" name="surat_tugas" accept="image/*">
                    <small class="text-muted">Maksimal ukuran file: 1MB</small>
                </div>

                <div class="mb-3">
                    <label for="proposal" class="form-label">Proposal</label>
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