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
$sheet->setCellValue('A1', 'Rank')
      ->setCellValue('B1', 'NIM')
      ->setCellValue('C1', 'Nama')
      ->setCellValue('D1', 'Program Studi')
      ->setCellValue('E1', 'Jenis Kelamin')
      ->setCellValue('F1', 'Email')
      ->setCellValue('G1', 'No. Telepon')
      ->setCellValue('H1', 'Jumlah Prestasi')
      ->setCellValue('I1', 'Total Poin');

// Tambahkan data mahasiswa
$row = 2; // Mulai dari baris kedua
foreach ($daftarMahasiswa as $mahasiswa) {
    $sheet->setCellValue('A' . $row, $mahasiswa['rank'])
          ->setCellValue('B' . $row, $mahasiswa['NIM'])
          ->setCellValue('C' . $row, $mahasiswa['nama'])
          ->setCellValue('D' . $row, $mahasiswa['prodi'])
          ->setCellValue('E' . $row, $mahasiswa['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan')
          ->setCellValue('F' . $row, $mahasiswa['email'])
          ->setCellValue('G' . $row, $mahasiswa['no_tlp'])
          ->setCellValue('H' . $row, $mahasiswa['total_prestasi'])
          ->setCellValue('I' . $row, $mahasiswa['total_poin']);
          
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
$sheet->getStyle('A1:I1')->applyFromArray($headerStyle);

// Set Auto Size untuk kolom
foreach (range('A', 'I') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Set nama file dan header HTTP
$filename = "daftar_mahasiswa.xlsx";

header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename= $filename");


// Simpan file ke output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
