<?php
require_once '../model/MahasiswaModel.php';

$mahasiswaModel = new MahasiswaModel();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['action'] === 'add') {

    }

    if ($_POST['action'] === 'remove') {}

    if ($_POST['action'] === 'ubah_password') {
        $nim = $_POST['nim'];
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
        
        $data = [
            'nim' => $nim,
            'currentPassword' => $currentPassword,
            'newPassword' => $newPassword,
            'confirmPassword' => $confirmPassword
        ];        // Cek password lama

        $result = $mahasiswaModel->changePassword($data);
        echo $result;
        // if ($currentPassword === $storedPassword) {
        //     if ($newPassword === $confirmPassword) {
        //         $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        //         echo 'Password berhasil diubah.';
        //     } else {
        //         echo 'Password baru dan konfirmasi tidak cocok.';
        //     }
        // } else {
        //     echo 'Password lama salah.';
        // }
    }
}
?>