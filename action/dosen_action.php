<?php
require_once '../model/DosenModel.php';
include '../fungsi/anti_injection.php';
session_start();
$dosenModel = new DosenModel();

require '../composer/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['action'] === 'add_dosen') {
        $data['nip'] = antiinjection($_POST['nip']);
        $data['nama'] = antiinjection($_POST['nama']);
        $data['jenis_kelamin'] = antiinjection($_POST['jenis_kelamin']);
        $data['email'] = antiinjection($_POST['email']);
        $data['no_tlp'] = antiinjection($_POST['no_tlp']);

        $status = $dosenModel->addDosen($data);

        if ($status === true) {
            $_SESSION['success_message'] = "Dosen Berhasil Ditambah";
        } else {
            $_SESSION['error_message'] = "Gagal Menambah Dosen";
        }
        header("Location: ../index.php?page=daftardosen");
    }

    if ($_POST['action'] === 'add_by_excel') {
        try {

            // Upload file
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excelFile'])) {
                $file = $_FILES['excelFile'];
                $allowedExtensions = ['xls', 'xlsx'];

                if ($file['error'] !== 0) {
                    throw new Exception('Error uploading file.');
                }

                $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
                if (!in_array($fileExtension, $allowedExtensions)) {
                    throw new Exception('Invalid file type.');
                }

                $uploadDir = '../uploads/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $filePath = $uploadDir . uniqid() . '.' . $fileExtension;
                if (!move_uploaded_file($file['tmp_name'], $filePath)) {
                    throw new Exception('Failed to save uploaded file.');
                }

                // Proses file Excel
                $spreadsheet = IOFactory::load($filePath);
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();

                $data = [];
                foreach ($rows as $index => $row) {
                    if ($index === 0 )
                        continue; // Skip header row
                    $data[] = [
                        'nip' => $row[0],
                        'nama' => $row[1],
                        'jenis_kelamin' => $row[2],
                        'email' => $row[3],
                        'no_tlp' => $row[4]
                    ];
                }

                // Masukkan data ke database
                $status = $dosenModel->addDosenByExcel($data);
                if ($status === true) {
                    unlink($filePath);
                    $_SESSION['success_message'] = "Daftar Dosen Berhasil Ditambah";
                } else {
                    unlink($filePath);
                    $_SESSION['error_message'] = "Gagal Menambah Dosen";
                }
                header("Location: ../index.php?page=daftardosen");
            }
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    if ($_POST['action'] === 'remove') {
        $nip = antiinjection($_POST['nip']);
        $status = $dosenModel->deleteDosen($nip);
        if ($status === true) {
            $_SESSION['success_message'] = "Dosen Berhasil Dihapus";
        } else {
            $_SESSION['error_message'] = "Gagal Menghapus Dosen";
        }
        header("Location: ../index.php?page=daftardosen");
    }

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

    if ($_POST['action'] === 'edit_data_dosen') {
        $data['new_nip'] = antiinjection($_POST['new_nip']);
        $data['nip'] = antiinjection($_POST['nip']);
        $data['nama'] = antiinjection($_POST['nama']);
        $data['jenis_kelamin'] = antiinjection($_POST['jenis_kelamin']);
        $data['email'] = antiinjection($_POST['email']);
        $data['no_tlp'] = antiinjection($_POST['no_tlp']);

        $filePP = antiinjection_files($_FILES);
        $data['file_foto_profile'] = !empty($filePP['file_foto_profile']['tmp_name']) ? file_get_contents($filePP['file_foto_profile']['tmp_name']) : null;
        $params = [
            $data['new_nip'],
            $data['nama'],
            $data['jenis_kelamin'],
            $data['email'],
            $data['no_tlp'],
            $data['file_foto_profile'],
            $data['nip']
        ];
        $status = $dosenModel->updateDataDosen($params);

        if ($status === true) {
            $_SESSION['success_message'] = "Biodata Berhasil Diubah";
        } else {
            $_SESSION['error_message'] = "Gagal Merubah Biodata";
        }
        $_SESSION['temp_nip'] = $data['new_nip'];
        header("Location: ../index.php?page=detaildosen");
    }

    if ($_POST['action'] === 'ubah_password_dosen_by_admin'){
        $nip = antiinjection($_POST['nip']);
        $password = antiinjection($_POST['password']);

        $status = $dosenModel->insertChangePassword($password, $nip);

        if ($status === "Password berhasil diubah.") {
            $_SESSION['success_message'] = "Password Berhasil Diubah";
        } else {
            $_SESSION['error_message'] = "Gagal Merubah Password";
        }
        $_SESSION['temp_nip'] = $nip;
        header("Location: ../index.php?page=detaildosen");
    }
}
?>