<?php
require_once '../model/MahasiswaModel.php';
include '../fungsi/anti_injection.php';
$mahasiswaModel = new MahasiswaModel();
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['action'] === 'add_mahasiswa') {
        $data['nim'] = antiinjection($_POST['nim']);
        $data['nama'] = antiinjection($_POST['nama']);
        $data['jenis_kelamin'] = antiinjection($_POST['jenis_kelamin']);
        $data['prodi'] = antiinjection($_POST['prodi']);
        $data['email'] = antiinjection($_POST['email']);
        $data['no_tlp'] = antiinjection($_POST['no_tlp']);

        $status = $mahasiswaModel->addMahasiswa($data);

        if ($status === true) {
            $_SESSION['success_message'] = "Mahasiswa Berhasil Ditambah";
        } else {
            $_SESSION['error_message'] = "Gagal Menambah Mahasiswa";
        }
        header("Location: ../index.php?page=daftarmahasiswa");
    }

    if ($_POST['action'] === 'remove') {
    }

    if ($_POST['action'] === 'ubah_password') {
        $nim = antiinjection($_POST['nim']);
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
            'nim' => $nim,
            'currentPassword' => $currentPassword,
            'newPassword' => $newPassword,
            'confirmPassword' => $confirmPassword
        ];        // Cek password lama

        $result = $mahasiswaModel->changePassword($data);
        echo $result;
    }

    if ($_POST['action'] === 'edit_biodata') {
        $data['email'] = antiinjection($_POST['email']);
        $data['no_tlp'] = antiinjection($_POST['no_tlp']);
        $data['nim'] = antiinjection($_POST['nim']);
        $filePP = antiinjection_files($_FILES);

        $filePP = antiinjection_files($_FILES);
        $data['file_foto_profile'] = !empty($filePP['file_foto_profile']['tmp_name']) ? file_get_contents($filePP['file_foto_profile']['tmp_name']) : null;

        $params = [
            $data['email'],
            $data['no_tlp'],
            $data['file_foto_profile'],
            $data['nim']
        ];
        $status = $mahasiswaModel->updateBiodata($params);

        if ($status === true) {
            $_SESSION['success_message'] = "Biodata Berhasil Diubah";
        } else {
            $_SESSION['error_message'] = "Gagal Merubah Biodata";
        }
        header("Location: ../index.php?page=profile");
    }
}
?>