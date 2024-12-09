<?php
require '../composer/vendor/autoload.php'; // Autoload Composer

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

require_once "../model/DosenModel.php";

ob_start(); // Start output buffering

// Ambil data dosen dari model
$dosenModel = new DosenModel();
$daftarDosen = $dosenModel->getAllDosen();

// Buat Spreadsheet baru
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set judul kolom
$sheet->setCellValue('A1', 'NIP')
      ->setCellValue('B1', 'Nama')
      ->setCellValue('C1', 'Jenis Kelamin')
      ->setCellValue('D1', 'No Telepon')
      ->setCellValue('E1', 'Email');

// Tambahkan data dosen
$row = 2; // Mulai dari baris kedua
foreach ($daftarDosen as $dosen) {
    $sheet->setCellValue('A' . $row, $dosen['nip'])
          ->setCellValue('B' . $row, $dosen['nama'])
          ->setCellValue('C' . $row, $dosen['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan')
          ->setCellValue('D' . $row, $dosen['no_tlp'])
          ->setCellValue('E' . $row, $dosen['email']);
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
$sheet->getStyle('A1:E1')->applyFromArray($headerStyle);

// Set Auto Size untuk kolom
foreach (range('A', 'E') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Set nama file dan header HTTP
$filename = "daftar_dosen.xlsx";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=$filename");
header('Cache-Control: max-age=0');

// Hapus output buffer sebelum mengirim file PDF
ob_end_clean();

// Simpan file ke output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
