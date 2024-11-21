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
                echo "<option value='" . $dosen['nip'] . "'>- " . htmlspecialchars($dosen['nama']) . "</option>"; // Menampilkan nama dosen
            }
        } else {
            echo "Tidak ada dosen yang ditemukan.";
        }
    }
    ?>

    <div class="kotak-judul">
        <p>Input Prestasi</p>
    </div><br>

    <div class="kotak-konten">
        <div class="container">
            <h1 class="mb-4">Masukan Prestasimu Disini</h1>
            <form action="../fungsi/add_prestasi.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="nim" id="nim" value="<?php echo $_SESSION['nim'] ?>">
                <!-- Nama Lomba -->
                <div class="mb-3">
                    <label for="namaLomba" class="form-label">Nama Lomba <span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="namaLomba" name="nama_lomba" required>
                </div>

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

                <!-- Juara Lomba -->
                <div class="mb-3">
                    <label for="juaraLomba" class="form-label">Juara Lomba <span style="color: red;">*</span></label>
                    <select class="form-select" id="juaraLomba" name="juara_lomba" required>
                        <option value="" disabled selected>Pilih Juara</option>
                        <option value="1">Juara 1</option>
                        <option value="2">Juara 2</option>
                        <option value="3">Juara 3</option>
                        <option value="lainnya">Kategori Lain</option>
                    </select>
                </div>

                <!-- Jenis Lomba -->
                <div class="mb-3">
                    <label for="jenisLomba" class="form-label">Jenis Lomba <span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="jenisLomba" name="jenis_lomba" required>
                </div>

                <div class="mb-3">
                    <label for="penyelenggaraLomba" class="form-label">Penyelenggara Lomba <span
                            style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="penyelenggaraLomba" name="penyelenggara_lomba" required>
                </div>

                <div class="mb-3">
                    <label for="dosenPembimbing" class="form-label">Dosen Pembimbing</label>
                    <select class="form-select" id="DosenPembimbig" name="dosbim">
                        <option value="" disabled selected>Pilih Dosen</option>
                        <?php getListDosen(); ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="waktuLomba" class="form-label">Waktu Pelaksanaan <span
                            style="color: red;">*</span></label>
                    <input type="date" class="form-control" id="waktuLomba" name="waktu_lomba" required>
                </div>

                <div class="mb-3">
                    <label for="tempatLomba" class="form-label">Tempat Pelaksanaan <span
                            style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="tempatLomba" name="tempat_lomba" required>
                </div>

                <!-- Sertifikat -->
                <div class="mb-3">
                    <label for="sertifikat" class="form-label">Sertifikat <span style="color: red;">*</span></label>
                    <input type="file" class="form-control" id="sertifikat" name="sertifikat" accept="image/*" required>
                    <small class="text-muted">Maksimal ukuran file: 1MB</small>
                </div>

                <div class="mb-3">
                    <label for="fotoLomba" class="form-label">Foto Saat Perlombaan <span
                            style="color: red;">*</span></label>
                    <input type="file" class="form-control" id="fotoLomba" name="foto_lomba" accept="image/*" required>
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
                    <small class="text-muted">Maksimal ukuran file: 1MB. Hanya file PDF yang diperbolehkan.</small>
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


</div>