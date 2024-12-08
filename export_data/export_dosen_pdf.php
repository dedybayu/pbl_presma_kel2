<?php
require '../composer/vendor/autoload.php'; // Autoload Composer

// Include DosenModel
require_once "../model/DosenModel.php";
$dosenModel = new DosenModel();
$daftarDosen = $dosenModel->getAllDosen();

// Pastikan tidak ada output sebelum file PDF dibuat
ob_start(); // Start output buffering

// Buat instance TCPDF
$pdf = new TCPDF();

// Set informasi dokumen
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Sistem Akademik');
$pdf->SetTitle('Daftar Dosen');
$pdf->SetSubject('Export PDF');
$pdf->SetKeywords('PDF, dosen, daftar');

// Hapus header dan footer default
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Tambahkan halaman
$pdf->AddPage();

// Atur font
$pdf->SetFont('helvetica', '', 10);

// Tambahkan judul
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Daftar Dosen', 0, 1, 'C');

// Tambahkan tabel
$pdf->SetFont('helvetica', '', 10);
$tableHTML = '<table border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr style="font-weight: bold; background-color: #f2f2f2;">
            <th style="background-color: #f2f2f2;">NIP</th>
            <th style="background-color: #f2f2f2;">Nama</th>
            <th style="background-color: #f2f2f2;">Jenis Kelamin</th>
            <th style="background-color: #f2f2f2;">No. Telepon</th>
            <th style="background-color: #f2f2f2;">Email</th>
        </tr>
    </thead>
    <tbody>';

// Tambahkan data Dosen ke tabel
foreach ($daftarDosen as $dosen) {
    $jenisKelamin = $dosen['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan';
    $tableHTML .= '<tr>
        <td>' . $dosen['nip'] . '</td>
        <td>' . $dosen['nama'] . '</td>
        <td>' . $jenisKelamin . '</td>
        <td>' . $dosen['no_tlp'] . '</td>
        <td>' . $dosen['email'] . '</td>
    </tr>';
}

$tableHTML .= '</tbody></table>';

// Tambahkan tabel ke PDF
$pdf->writeHTML($tableHTML, true, false, false, false, '');

// Hapus output buffer sebelum mengirim file PDF
ob_end_clean();

// Output file PDF
$pdf->Output('daftar_dosen.pdf', 'D');
exit;
?>
