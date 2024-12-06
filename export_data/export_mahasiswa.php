<?php
require '../composer/vendor/autoload.php'; // Autoload Composer

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

require_once "../model/MahasiswaModel.php";

// Ambil data mahasiswa dari model
$mahasiswaModel = new MahasiswaModel();
$daftarMahasiswa = $mahasiswaModel->getAllMahasiswa();

// Buat Spreadsheet baru
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set judul kolom
$sheet->setCellValue('A1', 'NIM')
      ->setCellValue('B1', 'Nama')
      ->setCellValue('C1', 'Program Studi')
      ->setCellValue('D1', 'Jenis Kelamin')
      ->setCellValue('E1', 'Email')
      ->setCellValue('F1', 'No. Telepon');

// Tambahkan data mahasiswa
$row = 2; // Mulai dari baris kedua
foreach ($daftarMahasiswa as $mahasiswa) {
    $sheet->setCellValue('A' . $row, $mahasiswa['NIM'])
          ->setCellValue('B' . $row, $mahasiswa['nama'])
          ->setCellValue('C' . $row, $mahasiswa['prodi'])
          ->setCellValue('D' . $row, $mahasiswa['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan')
          ->setCellValue('E' . $row, $mahasiswa['email'])
          ->setCellValue('F' . $row, $mahasiswa['no_tlp']);
    $row++;
}

// Style untuk header
$headerStyle = [
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
    'font' => [
        'bold' => true,
    ],
];
$sheet->getStyle('A1:F1')->applyFromArray($headerStyle);

// Set Auto Size untuk kolom
foreach (range('A', 'F') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Set nama file dan header HTTP
$filename = "daftar_mahasiswa.xlsx";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=$filename");
header('Cache-Control: max-age=0');

// Simpan file ke output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
