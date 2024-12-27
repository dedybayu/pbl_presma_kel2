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
require_once "model/PrestasiModel.php";
$listPrestasi = new PrestasiModel();
$prodiModel = new ProdiModel();
$daftarProdi = $prodiModel->getAllProdi();
$daftarPrestasi = $listPrestasi->getPrestasiByNim($nim);
?>
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
                            <td class="colon"><strong>:</strong></td>
                            <td><strong><?= $mahasiswa['nama']; ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-nowrap"><strong>NIM</strong></td>
                            <td class="colon"><strong>:</strong></td>
                            <td><strong><?= $mahasiswa['NIM']; ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-nowrap"><strong>Jenis Kelamin</strong></td>
                            <td class="colon"><strong>:</strong></td>
                            <td><strong><?php if ($mahasiswa['jenis_kelamin'] == 'L') {
                                echo "Laki-Laki";
                            } else {
                                echo "Perempuan";
                            } ?>
                                </strong></td>
                        </tr>
                        <tr>
                            <td class="text-nowrap"><strong>Program Studi</strong></td>
                            <td class="colon"><strong>:</strong></td>
                            <td><strong><?= $mahasiswa['prodi']; ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-nowrap"><strong>No. Telp</strong></td>
                            <td class="colon"><strong>:</strong></td>
                            <td><strong><?= $mahasiswa['no_tlp'] ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-nowrap"><strong>Email</strong></td>
                            <td class="colon"><strong>:</strong></td>
                            <td><strong><?= $mahasiswa['email']; ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div><br>
    
        <br>
        <?php
        if (empty($daftarPrestasi)) {
            ?>

            <div class="container">
                <h1>Mahasiswa Belum Memiliki Prestasi</h1>
                <br>
            </div>
            <?php
        } else {
            ?>
            
            <div class="table-container">
            <h1>Prestasi Mahasiswa</h1>
                <br>
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Juara</th>
                            <th>Tingkat</th>
                            <th>Tim</th>
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
                            echo "<tr>";
                            echo "<td>" . $prestasi['nama_lomba'] . "</td>";
                            echo "<td>" . "Juara " . $prestasi['juara_lomba'] . "</td>";
                            echo "<td>" . $prestasi['tingkat_lomba'] . "</td>";
                            echo "<td>" . $prestasi['status_tim'] . "</td>";
                            echo "<td>" . $prestasi['waktu_pelaksanaan']->format('j F Y') . "</td>";
                            echo "<td>" . $prestasi['penyelenggara_lomba'] . "</td>";
                            echo "<td>" . $prestasi['poin'] . "</td>";
                            echo "<td>" . $prestasi['upload_date']->format('d-m-Y H:i') . "</td>";
                            echo "<td>" . $prestasi['status_verifikasi'] . "</td>";
                            ?>
                            <td style="text-align: center; vertical-align: middle;">
                                <form action="index.php?page=detailprestasi" method="POST">
                                    <input type="hidden" name="idPrestasi" value="<?php echo $prestasi['id']; ?>">
                                    <button type="submit" class="btn btn-success btn-sm btn-detail">
                                        <i class="fa fa-edit"></i> Detail
                                    </button>
                                </form>

                            </td>
                            <?php
                            echo "</tr>";
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
    </div><br>
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