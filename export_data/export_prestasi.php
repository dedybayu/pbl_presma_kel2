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
$sheet->setCellValue('A1', 'Rank')
      ->setCellValue('B1', 'Nama Mahasiswa')
      ->setCellValue('C1', 'Nama Lomba')
      ->setCellValue('D1', 'Juara Lomba')
      ->setCellValue('E1', 'Status Tim')
      ->setCellValue('F1', 'Tingkat Lomba')
      ->setCellValue('G1', 'Waktu Pelaksanaan')
      ->setCellValue('H1', 'Penyelenggara Lomba')
      ->setCellValue('I1', 'Poin')
      ->setCellValue('J1', 'Total Poin')
      ->setCellValue('K1', 'Upload Date')
      ->setCellValue('L1', 'Status Verifikasi');

// Tambahkan data prestasi
$row = 2; // Mulai dari baris kedua
foreach ($daftarPrestasi as $prestasi) {
    $sheet->setCellValue('A' . $row, $prestasi['ranking'])
          ->setCellValue('B' . $row, $prestasi['nama_mhs'])
          ->setCellValue('C' . $row, $prestasi['nama_lomba'])
          ->setCellValue('D' . $row, $prestasi['juara_lomba'])
          ->setCellValue('E' . $row, $prestasi['status_tim'])
          ->setCellValue('F' . $row, $prestasi['tingkat_lomba'])
          ->setCellValue('G' . $row, $prestasi['waktu_pelaksanaan']->format('Y-m-d')) // Format date
          ->setCellValue('H' . $row, $prestasi['penyelenggara_lomba'])
          ->setCellValue('I' . $row, $prestasi['poin'])
          ->setCellValue('J' . $row, $prestasi['total_poin'])
          ->setCellValue('K' . $row, $prestasi['upload_date']->format('Y-m-d H:i:s')) // Format datetime
          ->setCellValue('L' . $row, $prestasi['status_verifikasi']);
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
$sheet->getStyle('A1:L1')->applyFromArray($headerStyle);

// Set Auto Size untuk kolom
foreach (range('A', 'L') as $columnID) {
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
