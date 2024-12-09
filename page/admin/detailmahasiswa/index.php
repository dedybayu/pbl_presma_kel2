<?php
require 'model/MahasiswaModel.php';
include 'fungsi/anti_injection.php';
if (isset($_POST['nim'])) {
    $nim = antiinjection($_POST['nim']);
} else {
    $nim = $_SESSION['temp_nim'];
}
$mahasiswaModel = new MahasiswaModel();
$mahasiswa = $mahasiswaModel->getMahasiswaByNim($nim);
if (!$mahasiswa) {
    echo "Mahasiswa tidak ditemukan!";
    exit;
}
require_once "model/ProdiModel.php";
$prodiModel = new ProdiModel();
$daftarProdi = $prodiModel->getAllProdi();
?>
<!-- Content Area -->
<div class="content">
    <div class="kotak-judul">
        <p>Profile Mahasiswa</p>
    </div>
    <div class="kotak-konten">
        <h1>Biodata Mahasiswa</h1>
        <hr>
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
        <br>
        <div class="row g-4">
            <!-- Sertifikat -->
            <div class="col-12 col-md-6 foto-profile-box">
                <div class="FotoContainer">
                    <?php
                    if (!empty($mahasiswa['file_foto_profile'])) {
                        echo '<img class="foto_profile" src="data:image/jpeg;base64,' . base64_encode($mahasiswa['file_foto_profile']) . '" alt="fotoProfile" data-title="fotoProfile">';
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
                            <td><strong><?= $mahasiswa['nama']; ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-nowrap"><strong>NIM</strong></td>
                            <td class="colon">:</td>
                            <td><strong><?= $mahasiswa['NIM']; ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-nowrap"><strong>Jenis Kelamin</strong></td>
                            <td class="colon">:</td>
                            <td><strong><?php if ($mahasiswa['jenis_kelamin'] == 'L') {
                                echo "Laki-Laki";
                            } else {
                                echo "Perempuan";
                            } ?>
                                </strong></td>
                        </tr>
                        <tr>
                            <td class="text-nowrap"><strong>No. Telp</strong></td>
                            <td class="colon">:</td>
                            <td><strong><?= $mahasiswa['no_tlp'] ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-nowrap"><strong>Email</strong></td>
                            <td class="colon">:</td>
                            <td><strong><?= $mahasiswa['email']; ?></strong></td>
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
            <form action="action/mahasiswa_action.php" method="POST">
                <input type="hidden" name="action" id="action" value="remove">
                <input type="hidden" name="nim" id="nim" value="<?= $mahasiswa['NIM']; ?>">
                <button type="submit" class="btn btn-primary" style="background-color: red; border: red:">Hapus
                    Dosen</button>
            </form>
        </div>
    </div><br>
</div>

<!-- Modal untuk Ubah Password -->
<div class="modal fade" id="ubahPasswordModal" tabindex="-1" aria-labelledby="ubahPasswordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahPasswordModalLabel">Ubah Password Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form untuk ubah password -->
                <form id="passwordForm" action="action/mahasiswa_action.php" method="POST">
                    <input type="hidden" name="action" id="action" value="ubah_password_mhs_by_admin">
                    <input type="hidden" name="nim" id="nim" value="<?= $mahasiswa['NIM']; ?>">
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
                            placeholder="Konfirmasi password baru" name="password" required>
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
                <button type="button" class="btn btn-primary" form="passwordForm" id="saveChangesBtn">Simpan
                    Perubahan</button>
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
                <p>Password Mahasiswa telah berhasil diubah.</p>
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
                <form id="editProfileForm" action="action/mahasiswa_action.php" method="POST"
                    enctype="multipart/form-data">
                    <input type="hidden" name="action" value="edit_data_mahasiswa">
                    <input type="hidden" name="nim" value="<?= $mahasiswa['NIM']; ?>">
                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="newnim" name="new_nim"
                            value="<?= $mahasiswa['NIM']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= $mahasiswa['nama']; ?>"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="jenisKelamin" class="form-label">Jenis Kelamin <span
                                style="color: red;">*</span></label>
                        <select class="form-select" id="jenisKelamin" name="jenis_kelamin" required>
                            <option value="" disabled selected>Jenis Kelamin</option>
                            <option value="L" <?php if ($mahasiswa['jenis_kelamin'] == 'L') {
                                echo "selected";
                            } ?>>Laki-Laki
                            </option>
                            <option value="P" <?php if ($mahasiswa['jenis_kelamin'] == 'P') {
                                echo "selected";
                            } ?>>Perempuan
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="prodi" class="form-label">Prodi <span style="color: red;">*</span></label>
                        <select class="form-select" id="prodi" name="prodi" required>
                            <option value="" disabled selected>Pilih Prodi</option>
                            <?php
                            foreach ($daftarProdi as $prodi) {
                                if ($prodi['id'] == $mahasiswa['id_prodi']) {
                                    echo '<option value="' . $prodi['id'] . '" selected>' . $prodi['nama_prodi'] . '</option>';
                                } else {
                                    echo '<option value="' . $prodi['id'] . '">' . $prodi['nama_prodi'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email"
                            value="<?= $mahasiswa['email']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="noTlp" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="noTlp" name="no_tlp"
                            placeholder="Masukkan nomor telepon" value="<?= $mahasiswa['no_tlp']; ?>">
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

    function checkPasswords() {
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        const passwordError = document.getElementById('passwordError');
        const passwordMinimal = document.getElementById('passwordMinimal');
        const fieldRequired = document.getElementById('fieldRequired');

        // Reset errors
        passwordError.style.display = 'none';
        passwordMinimal.style.display = 'none';
        fieldRequired.style.display = 'none';

        // Check if both passwords match
        if (newPassword !== confirmPassword) {
            passwordError.style.display = 'block'; // Show mismatch warning
            return false;
        }

        // Check if password is long enough (e.g., minimum 8 characters)
        if (newPassword.length < 8) {
            passwordMinimal.style.display = 'block'; // Show minimum length warning
            passwordMinimal.innerHTML = 'Password minimal 8 karakter.';
            return false;
        }

        // Check if any field is empty
        if (!newPassword || !confirmPassword) {
            fieldRequired.style.display = 'block'; // Show required field warning
            fieldRequired.innerHTML = 'Semua kolom harus diisi.';
            return false;
        }

        return true;
    }


    document.getElementById('saveChangesBtn').addEventListener('click', function (event) {
        // Prevent form submission if validation fails
        if (!checkPasswords()) {
            event.preventDefault(); // Prevent form submission
        } else {
            // Proceed with form submission if passwords match
            document.getElementById('passwordForm').submit();
        }
    });
    $('#ubahPasswordModal').on('hidden.bs.modal', function () {
        // Reset form and hide error messages after the modal closes
        document.getElementById('passwordForm').reset();
        document.getElementById('currentPasswordError').style.display = 'none';
        document.getElementById('passwordError').style.display = 'none';
        document.getElementById('passwordMinimal').style.display = 'none';
        document.getElementById('fieldRequired').style.display = 'none';
        document.getElementById('currentPasswordError').innerHTML = '';
        document.getElementById('passwordError').innerHTML = '';
        document.getElementById('passwordMinimal').innerHTML = '';
        document.getElementById('fieldRequired').innerHTML = '';
    });

</script>