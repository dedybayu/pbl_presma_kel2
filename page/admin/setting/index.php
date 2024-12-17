<!-- Content Area -->
<div class="content">
    <div class="kotak-judul">
        <p>Setting Admin</p>
    </div><br>
    <div class="kotak-konten">
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
        <div class="d-flex justify-content-center">
            <table style="width: auto; height: 100%; border: none;">
                <tr style="height: 100%;">
                    <td style="text-align: left; vertical-align: middle;">
                        <button class="tombol-dark" id="darkModeToggle" onclick="toggleDarkMode()"
                            style="margin-right: 20px;">
                            <i class="bi bi-moon"></i> Dark Mode
                        </button>
                    </td>
                    <td style="text-align: right; vertical-align: middle;">
                        <button id="ubahPassword" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#ubahPasswordModal" style="margin-left: 20px;">Ubah Password</button>
                    </td>
                </tr>
            </table>
        </div>



    </div>
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
                <form id="passwordForm" action="action/admin_action.php" method="POST">
                    <input type="hidden" name="action" id="action" value="change_password">
                    <input type="hidden" name="username" id="username" value="<?= $_SESSION['username'] ?>">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username Baru</label>
                        <input type="text" class="form-control" id="newUsername" name="new_username"
                            placeholder="Masukkan password baru" value="<?= $_SESSION['username'] ?>" required>
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
</script>