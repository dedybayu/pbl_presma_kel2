<?php
require '../composer/vendor/autoload.php'; // Autoload Composer

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

// Ganti ini dengan model atau cara Anda mengambil data dari database
require_once "../model/PrestasiModel.php";

ob_start(); // Start output buffering

// Ambil data lomba dari model
$prestasiModel = new PrestasiModel();
$daftarPrestasi= $prestasiModel->getAllPrestasi(); // Pastikan fungsi ini mengambil semua data dari tabel

// Buat Spreadsheet baru
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set judul kolom (tanpa kolom ID)
$sheet->setCellValue('A1', 'Nama Mahasiswa')
      ->setCellValue('B1', 'Nama Lomba')
      ->setCellValue('C1', 'Juara Lomba')
      ->setCellValue('D1', 'Status Tim')
      ->setCellValue('E1', 'Tingkat Lomba')
      ->setCellValue('F1', 'Waktu Pelaksanaan')
      ->setCellValue('G1', 'Penyelenggara Lomba')
      ->setCellValue('H1', 'Poin')
      ->setCellValue('I1', 'Upload Date')
      ->setCellValue('J1', 'Status Verifikasi');

// Tambahkan data prestasi
$row = 2; // Mulai dari baris kedua
foreach ($daftarPrestasi as $prestasi) {
    $sheet->setCellValue('A' . $row, $prestasi['nama_mhs'])
          ->setCellValue('B' . $row, $prestasi['nama_lomba'])
          ->setCellValue('C' . $row, $prestasi['juara_lomba'])
          ->setCellValue('D' . $row, $prestasi['status_tim'])
          ->setCellValue('E' . $row, $prestasi['tingkat_lomba'])
          ->setCellValue('F' . $row, $prestasi['waktu_pelaksanaan']->format('Y-m-d')) // Format date
          ->setCellValue('G' . $row, $prestasi['penyelenggara_lomba'])
          ->setCellValue('H' . $row, $prestasi['poin'])
          ->setCellValue('I' . $row, $prestasi['upload_date']->format('Y-m-d H:i:s')) // Format datetime
          ->setCellValue('J' . $row, $prestasi['status_verifikasi']);
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
$sheet->getStyle('A1:O1')->applyFromArray($headerStyle);

// Set Auto Size untuk kolom
foreach (range('A', 'O') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Set nama file dan header HTTP
$filename = "daftar_prestasi.xlsx";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=$filename");
header('Cache-Control: max-age=0');

// Hapus output buffer sebelum mengirim file Excel
ob_end_clean();

// Simpan file ke output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
