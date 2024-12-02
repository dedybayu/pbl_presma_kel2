<!-- Content Area -->
<div class="content">
    <div class="kotak-judul">
        <p>Profile Mahasiswa</p>
    </div>
    <div class="kotak-konten">
        <h1>Biodata Mahasiswa</h1>
        <hr>
        <br>
        <div class="row g-4">
            <!-- Sertifikat -->
            <div class="col-12 col-md-6 foto-profile-box">
                <div class="FotoContainer">
                    <?php
                    if (!empty($row['file_foto_profile'])) {
                        echo '<img class="foto_profile" src="data:image/jpeg;base64,' . base64_encode($prestasi['file_foto_profile']) . '" alt="fotoProfile" data-title="fotoProfile">';
                    } else {
                        echo '<span class="foto_profile" id="noFoto">Tidak ada foto profile</span>';
                    }
                    ?>
                </div>
            </div>
            <div class="col-12 col-md-6 box-transparen">

                <table class="table table-borderless align-middle">
                    <tbody>
                        <tr>
                            <td class="text-nowrap"><strong>Nama</strong></td>
                            <td class="colon">:</td>
                            <td><strong><?= $row['nama']; ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-nowrap"><strong>NIM</strong></td>
                            <td class="colon">:</td>
                            <td><strong><?= $row['NIM']; ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-nowrap"><strong>Jenis Kelamin</strong></td>
                            <td class="colon">:</td>
                            <td><strong><?= ucfirst(strtolower($row['jenis_kelamin'])); ?>
                                </strong></td>
                        </tr>
                        <tr>
                            <td class="text-nowrap"><strong>No. Telp</strong></td>
                            <td class="colon">:</td>
                            <td><strong><?= $row['no_tlp'] ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-nowrap"><strong>Email</strong></td>
                            <td class="colon">:</td>
                            <td><strong><?= $row['email']; ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div><br>

        <div class="d-flex justify-content-center">
            <button id="ubahPassword" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#ubahPasswordModal">Ubah Password</button>
            <button id="editProfile" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#editProfileModal">Edit Biodata</button>
        </div>
    </div><br>
</div>

<!-- Modal untuk Ubah Password -->
<div class="modal fade" id="ubahPasswordModal" tabindex="-1" aria-labelledby="ubahPasswordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahPasswordModalLabel">Ubah Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form untuk ubah password -->
                <form id="passwordForm">
                    <input type="hidden" name="action" id="action" value="ubah_password">
                    <input type="hidden" name="nim" id="nim" value="<?= $row['NIM']; ?>">
                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Password Lama</label>
                        <input type="password" class="form-control" id="currentPassword"
                            placeholder="Masukkan password lama" required>
                    </div>
                    <div id="currentPasswordError" class="text-danger mt-2" style="display: none;">Password lama salah.
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" id="newPassword"
                            placeholder="Masukkan password baru" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="confirmPassword"
                            placeholder="Konfirmasi password baru" required>
                        <div id="passwordError" class="text-danger mt-2" style="display: none;">Password baru dan
                            konfirmasi tidak cocok.</div>
                        <div id="passwordMinimal" class="text-danger mt-2" style="display: none;"></div>
                        <div id="fieldRequired" class="text-danger mt-2" style="display: none;"></div>
                        <div id="peringatanPassword" class="text-danger mt-2" style="display: none;"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="saveChangesBtn">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal untuk Password Berhasil Dirubah -->
<div class="modal fade" id="passwordSuccessModal" tabindex="-1" aria-labelledby="passwordSuccessModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="passwordSuccessModalLabel">Password Berhasil Dirubah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Password Anda telah berhasil diubah.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal untuk Edit Biodata -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Biodata</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form untuk edit biodata -->
                <form id="editProfileForm">
                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM</label>
                        <input type="text" class="form-control" id="nim" value="<?= $row['NIM']; ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" value="<?= $row['nama']; ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="nim" class="form-label">Jenis Kelamin</label>
                        <input type="text" class="form-control" id="nim"
                            value="<?= ucfirst(strtolower($row['jenis_kelamin'])); ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Masukkan email">
                    </div>
                    <div class="mb-3">
                        <label for="noTlp" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="noTlp" placeholder="Masukkan nomor telepon">
                    </div>
                    <div class="mb-3">
                        <label for="fileFotoProfile" class="form-label">Foto Profile</label>
                        <input type="file" class="form-control" id="fileFotoProfile" name="file_foto_profile"
                            accept="image/*">
                        <small class="text-infoFile">Maksimal ukuran file: 1MB</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <!-- Tombol submit yang terhubung ke form -->
                <button type="submit" class="btn btn-primary" form="editProfileForm" id="submitBtn">Simpan
                    Perubahan</button>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-primary {
        margin: 10px !important;
    }

    .foto_profile {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
    }

    /* Membuat foto-profile-box berbentuk kotak */
    .foto-profile-box {
        border: 2px solid #ddd;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: rgba(39, 102, 121, 0.274);
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    @media (max-width: 766px) {
        .foto-profile-box {
            width: auto;
            margin: auto;
        }


    }

    @media (min-width: 767px) {
        .foto-profile-box {
            width: auto;
        }

    }

    /* Opsional: Gaya teks jika tidak ada foto */
    #noFoto {
        color: #555;
        /* Warna teks */
        font-style: italic;
        /* Gaya miring */
    }

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
    document.getElementById('editProfileForm').addEventListener('submit', function (event) {
        const MAX_IMAGE_SIZE = 1 * 1024 * 1024; // 1MB
        let isValid = true;

        // Bersihkan pesan error sebelumnya
        document.querySelectorAll('.error-message').forEach(el => el.remove());

        // Fungsi untuk menampilkan pesan error
        const showError = (element, message) => {
            const errorMessage = document.createElement('div');
            errorMessage.className = 'error-message text-danger mt-2';
            errorMessage.textContent = message;
            element.parentElement.appendChild(errorMessage);
        };

        // Validasi file foto
        const fileInput = document.getElementById('fileFotoProfile');
        const file = fileInput.files[0];

        if (file) {
            if (file.size > MAX_IMAGE_SIZE) {
                showError(fileInput, `File ${file.name} melebihi ukuran maksimal 1MB.`);
                isValid = false;
            }
        }

        // Jika validasi gagal, batalkan submit
        if (!isValid) {
            event.preventDefault();
        }
    });

    // Fungsi untuk memeriksa kecocokan password baru dan konfirmasi
    function checkPasswords() {
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        const passwordError = document.getElementById('passwordError');

        if (newPassword !== confirmPassword) {
            passwordError.style.display = 'block'; // Tampilkan peringatan
            return false;
        } else {
            passwordError.style.display = 'none'; // Sembunyikan peringatan
            return true;
        }
    }

    document.getElementById('saveChangesBtn').addEventListener('click', function () {
        const currentPassword = document.getElementById('currentPassword').value;
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        const action = document.getElementById('action').value;
        const nim = document.getElementById('nim').value;

        // Kirim data ke server menggunakan AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'action/mahasiswa_action.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = xhr.responseText;

                // Jika password lama salah
                if (response === 'Password lama salah.') {
                    document.getElementById('fieldRequired').style.display = 'none';
                    document.getElementById('currentPasswordError').innerHTML = response;
                    document.getElementById('currentPasswordError').style.display = 'block';
                } else if (response === 'Password baru harus memiliki minimal 8 karakter.') {
                    document.getElementById('fieldRequired').style.display = 'none';
                    document.getElementById('passwordMinimal').innerHTML = response;
                    document.getElementById('passwordMinimal').style.display = 'block';
                } else if (response === 'Password berhasil diubah.') {
                    // Tutup modal Ubah Password
                    $('#ubahPasswordModal').modal('hide');

                    // Menampilkan modal Password Berhasil Dirubah
                    $('#passwordSuccessModal').modal('show');
                } else if (response === 'Semua field harus diisi.') {
                    document.getElementById('fieldRequired').innerHTML = response;
                    document.getElementById('fieldRequired').style.display = 'block';
                } else {
                    document.getElementById('peringatanPassword').innerHTML = response;
                    document.getElementById('peringatanPassword').style.display = 'block';
                }


                // else {
                //     document.getElementById('currentPasswordError').style.display = 'none'; // Sembunyikan error password lama
                //     alert(response); // Tampilkan respon dari server
                //     // Jika berhasil, tutup modal
                //     $('#ubahPasswordModal').modal('hide');
                // }
            }
        };
        xhr.send(`action=${encodeURIComponent(action)}&nim=${encodeURIComponent(nim)}&currentPassword=${encodeURIComponent(currentPassword)}&newPassword=${encodeURIComponent(newPassword)}&confirmPassword=${encodeURIComponent(confirmPassword)}`);
    });


    $('#passwordSuccessModal').on('hidden.bs.modal', function () {
        // Reset form dan sembunyikan pesan error setelah modal ditutup
        document.getElementById('passwordForm').reset();
        document.getElementById('currentPasswordError').style.display = 'none';
        document.getElementById('passwordError').style.display = 'none';
        document.getElementById('passwordMinimal').style.display = 'none';
        document.getElementById('currentPasswordError').innerHTML = '';
        document.getElementById('passwordError').innerHTML = '';
        document.getElementById('passwordMinimal').innerHTML = '';
    });

</script>