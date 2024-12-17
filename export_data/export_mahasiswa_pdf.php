<?php
require '../composer/vendor/autoload.php'; // Autoload Composer

// Include MahasiswaModel
require_once "../model/MahasiswaModel.php";
$mahasiswaModel = new MahasiswaModel();
$daftarMahasiswa = $mahasiswaModel->getAllMahasiswa();

// Pastikan tidak ada output sebelum file PDF dibuat
ob_start(); // Start output buffering

// Buat instance TCPDF
$pdf = new TCPDF();

// Set informasi dokumen
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Sistem Akademik');
$pdf->SetTitle('Daftar Mahasiswa');
$pdf->SetSubject('Export PDF');
$pdf->SetKeywords('PDF, mahasiswa, daftar');

// Hapus header dan footer default
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Tambahkan halaman
$pdf->AddPage();

// Atur font
$pdf->SetFont('helvetica', '', 10);

// Tambahkan judul
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Daftar Mahasiswa', 0, 1, 'C');

// Tambahkan tabel
$pdf->SetFont('helvetica', '', 10);
$tableHTML = '<table border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr style="font-weight: bold; background-color: #f2f2f2;">
            <th style="background-color: #f2f2f2;">Rank</th>
            <th style="background-color: #f2f2f2;">NIM</th>
            <th style="background-color: #f2f2f2;">Nama</th>
            <th style="background-color: #f2f2f2;">Program Studi</th>
            <th style="background-color: #f2f2f2;">Jenis Kelamin</th>
            <th style="background-color: #f2f2f2;">Email</th>
            <th style="background-color: #f2f2f2;">No. Telepon</th>
            <th style="background-color: #f2f2f2;">Prestasi</th>
            <th style="background-color: #f2f2f2;">Poin</th>
        </tr>
    </thead>
    <tbody>';

// Tambahkan data mahasiswa ke tabel
foreach ($daftarMahasiswa as $mahasiswa) {
    $jenisKelamin = $mahasiswa['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan';
    $tableHTML .= '<tr>
        <td>' . $mahasiswa['Rank'] . '</td>
        <td>' . $mahasiswa['NIM'] . '</td>
        <td>' . $mahasiswa['nama'] . '</td>
        <td>' . $mahasiswa['prodi'] . '</td>
        <td>' . $jenisKelamin . '</td>
        <td>' . $mahasiswa['email'] . '</td>
        <td>' . $mahasiswa['no_tlp'] . '</td>
        <td>' . $mahasiswa['total_prestasi'] . '</td>
        <td>' . $mahasiswa['total_poin'] . '</td>
    </tr>';
}

$tableHTML .= '</tbody></table>';

// Tambahkan tabel ke PDF
$pdf->writeHTML($tableHTML, true, false, false, false, '');

// Hapus output buffer sebelum mengirim file PDF
ob_end_clean();

// Output file PDF
$pdf->Output('daftar_mahasiswa.pdf', 'D');
exit;
?>
