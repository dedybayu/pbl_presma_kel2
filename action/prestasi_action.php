<?php
require_once '../controller/PrestasiController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $controller = new PrestasiController();

    $data = [
        'nim' => $_POST['nim'],
        'nama_lomba' => $_POST['nama_lomba'],
        'tingkat_lomba' => $_POST['tingkat_lomba'],
        'juara_lomba' => $_POST['juara_lomba'],
        'jenis_lomba' => $_POST['jenis_lomba'],
        'penyelenggara_lomba' => $_POST['penyelenggara_lomba'],
        'dosbim' => $_POST['dosbim'],
        'tempat_lomba' => $_POST['tempat_lomba'],
        'waktu_lomba' => $_POST['waktu_lomba']
    ];

    $controller->addPrestasi($data, $_FILES);
}
?>
