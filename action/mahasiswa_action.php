<?php
require_once '../model/MahasiswaModel.php';
include '../fungsi/anti_injection.php';
$mahasiswaModel = new MahasiswaModel();
session_start();

require '../composer/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

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
                        'nim' => $row[0],
                        'nama' => $row[1],
                        'jenis_kelamin' => $row[2],
                        'prodi' => $row[3],
                        'email' => $row[4],
                        'no_tlp' => $row[5]
                    ];
                }

                // Masukkan data ke database
                $status = $mahasiswaModel->addMahasiswaByExcel($data);
                if ($status === true) {
                    unlink($filePath);
                    $_SESSION['success_message'] = "Daftar Mahasiswa Berhasil Ditambah";
                } else {
                    unlink($filePath);
                    $_SESSION['error_message'] = "Gagal Menambah Mahasiswa";
                }
                header("Location: ../index.php?page=daftarmahasiswa");
            }
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
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

    if ($_POST['action'] === 'edit_data_mahasiswa') {
        $data['new_nim'] = antiinjection($_POST['new_nim']);
        $data['nim'] = antiinjection($_POST['nim']);
        $data['nama'] = antiinjection($_POST['nama']);
        $data['jenis_kelamin'] = antiinjection($_POST['jenis_kelamin']);
        $data['prodi'] = antiinjection($_POST['prodi']);
        $data['email'] = antiinjection($_POST['email']);
        $data['no_tlp'] = antiinjection($_POST['no_tlp']);

        $filePP = antiinjection_files($_FILES);
        $data['file_foto_profile'] = !empty($filePP['file_foto_profile']['tmp_name']) ? file_get_contents($filePP['file_foto_profile']['tmp_name']) : null;
        $params = [
            $data['new_nim'],
            $data['nama'],
            $data['jenis_kelamin'],
            $data['prodi'],
            $data['email'],
            $data['no_tlp'],
            $data['file_foto_profile'],
            $data['nim']
        ];
        $status = $mahasiswaModel->updateDataMahasiswa($params);

        if ($status === true) {
            $_SESSION['success_message'] = "Biodata Berhasil Diubah";
        } else {
            $_SESSION['error_message'] = "Gagal Merubah Biodata";
        }
        $_SESSION['temp_nim'] = $data['new_nim'];
        header("Location: ../index.php?page=detailmahasiswa");
    }

    if ($_POST['action'] === 'ubah_password_mhs_by_admin'){
        $nim = antiinjection($_POST['nim']);
        $password = antiinjection($_POST['password']);

        $status = $mahasiswaModel->insertChangePassword($password, $nim);

        if ($status === "Password berhasil diubah.") {
            $_SESSION['success_message'] = "Password Berhasil Diubah";
        } else {
            $_SESSION['error_message'] = "Gagal Merubah Password";
        }
        $_SESSION['temp_nim'] = $nim;
        header("Location: ../index.php?page=detailmahasiswa");
    }
}
?>