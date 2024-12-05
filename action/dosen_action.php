<?php
require_once '../model/DosenModel.php';
include '../fungsi/anti_injection.php';
session_start();
$dosenModel = new DosenModel();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['action'] === 'add_dosen') {
        $data['nip'] = antiinjection($_POST['nip']);
        $data['nama'] = antiinjection($_POST['nama']);
        $data['jenis_kelamin'] = antiinjection($_POST['jenis_kelamin']);
        $data['email'] = antiinjection($_POST['email']);
        $data['no_tlp'] = antiinjection($_POST['no_tlp']);

        $dosenModel->addDosen($data);

        if ($status === true) {
            $_SESSION['success_message'] = "Dosen Berhasil Ditambah";
        } else {
            $_SESSION['error_message'] = "Gagal Menambah Dosen";
        }
        header("Location: ../index.php?page=daftardosen");
    }

    if ($_POST['action'] === 'remove') {}

    if ($_POST['action'] === 'ubah_password') {
        $nip = antiinjection($_POST['nip']);
        $currentPassword = antiinjection($_POST['currentPassword']);
        $newPassword = antiinjection($_POST['newPassword']);
        $confirmPassword = antiinjection($_POST['confirmPassword']);
    
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
    }

    if ($_POST['action'] === 'edit_biodata') {
        $data['email'] = antiinjection($_POST['email']);
        $data['no_tlp'] = antiinjection($_POST['no_tlp']);
        $data['nip'] = antiinjection($_POST['nip']);
        $filePP = antiinjection_files($_FILES);

        $filePP = antiinjection_files($_FILES);
        $data['file_foto_profile'] = !empty($filePP['file_foto_profile']['tmp_name']) ? file_get_contents($filePP['file_foto_profile']['tmp_name']) : null;

        $params = [
            $data['email'],
            $data['no_tlp'],
            $data['file_foto_profile'],
            $data['nip']
        ];
        $status = $dosenModel->updateBiodata($params);

        if ($status === true) {
            $_SESSION['success_message'] = "Biodata Berhasil Diubah";
        } else {
            $_SESSION['error_message'] = "Gagal Merubah Biodata";
        }
        header("Location: ../index.php?page=profile");
    }
}
?>