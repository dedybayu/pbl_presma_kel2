<?php
// Password lama yang disimpan secara statis (misalnya, password hash di sini)
$storedPassword = '12345678'; // Contoh password hash (misalnya "passwordlama")

// PHP script ubah_password.php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validasi input
    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        echo 'Semua field harus diisi.';
        exit;
    }

    // Validasi panjang password baru
    if (strlen($newPassword) < 8) {
        echo 'Password baru harus memiliki minimal 8 karakter.';
        exit;
    }

    // Cek password lama
    if ($currentPassword === $storedPassword) {
        if ($newPassword === $confirmPassword) {
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            echo 'Password berhasil diubah.';
        } else {
            echo 'Password baru dan konfirmasi tidak cocok.';
        }
    } else {
        echo 'Password lama salah.';
    }
}
