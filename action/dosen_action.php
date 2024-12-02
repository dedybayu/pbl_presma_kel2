<?php
require_once '../model/DosenModel.php';

$dosenModel = new DosenModel();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['action'] === 'add') {

    }

    if ($_POST['action'] === 'remove') {}

    if ($_POST['action'] === 'ubah_password') {
        $nip = $_POST['nip'];
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
            'nip' => $nip,
            'currentPassword' => $currentPassword,
            'newPassword' => $newPassword,
            'confirmPassword' => $confirmPassword
        ];        // Cek password lama

        $result = $dosenModel->changePassword($data);
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