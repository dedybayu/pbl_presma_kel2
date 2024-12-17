<?php
require '../composer/vendor/autoload.php'; // Autoload Composer

// Include PrestasiModel
require_once "../model/PrestasiModel.php";
$prestasiModel = new PrestasiModel();
include '../fungsi/anti_injection.php';

ob_start(); // Start output buffering

// Ambil data lomba dari model
$prestasiModel = new PrestasiModel();
$daftarPrestasi= $prestasiModel->getPrestasiByDosen(antiinjection($_POST['nip']));

// Buat instance TCPDF
$pdf = new TCPDF();

// Set informasi dokumen
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Sistem Akademik');
$pdf->SetTitle('Daftar Prestasi');
$pdf->SetSubject('Export PDF');
$pdf->SetKeywords('PDF, prestasi, daftar');

// Hapus header dan footer default
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Tambahkan halaman
$pdf->AddPage();

// Atur font
$pdf->SetFont('helvetica', '', 10);

// Tambahkan judul
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Daftar Prestasi Mahasiswa', 0, 1, 'C');

// Tambahkan tabel
$pdf->SetFont('helvetica', '', 10);
$tableHTML = '<table border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr style="font-weight: bold; background-color: #f2f2f2;">
            <th>Rank</th>
            <th>Nama Mahasiswa</th>
            <th>Nama Lomba</th>
            <th>Juara Lomba</th>
            <th>Status Tim</th>
            <th>Tingkat Lomba</th>
            <th>Waktu Pelaksanaan</th>
            <th>Penyelenggara Lomba</th>
            <th>Poin</th>
            <th>Total Poin</th>
            <th>Upload Date</th>
            <th>Status Verifikasi</th>
        </tr>
    </thead>
    <tbody>';

// Tambahkan data Prestasi ke tabel
foreach ($daftarPrestasi as $prestasi) {
    // Pastikan jika data waktu adalah objek DateTime, ubah menjadi string
    $waktuPelaksanaan = $prestasi['waktu_pelaksanaan'] instanceof DateTime
        ? $prestasi['waktu_pelaksanaan']->format('Y-m-d')  // Atur format yang diinginkan
        : $prestasi['waktu_pelaksanaan'];

    $uploadDate = $prestasi['upload_date'] instanceof DateTime
        ? $prestasi['upload_date']->format('Y-m-d')  // Format yang sama atau sesuaikan
        : $prestasi['upload_date'];

    $tableHTML .= '<tr>
        <td>' . htmlspecialchars($prestasi['ranking']) . '</td>
        <td>' . htmlspecialchars($prestasi['nama_mhs']) . '</td>
        <td>' . htmlspecialchars($prestasi['nama_lomba']) . '</td>
        <td>' . htmlspecialchars($prestasi['juara_lomba']) . '</td>
        <td>' . htmlspecialchars($prestasi['status_tim']) . '</td>
        <td>' . htmlspecialchars($prestasi['tingkat_lomba']) . '</td>
        <td>' . htmlspecialchars($waktuPelaksanaan) . '</td>
        <td>' . htmlspecialchars($prestasi['penyelenggara_lomba']) . '</td>
        <td>' . htmlspecialchars($prestasi['poin']) . '</td>
        <td>' . htmlspecialchars($prestasi['total_poin']) . '</td>
        <td>' . htmlspecialchars($uploadDate) . '</td>
        <td>' . htmlspecialchars($prestasi['status_verifikasi']) . '</td>
    </tr>';
}


$tableHTML .= '</tbody></table>';

// Tambahkan tabel ke PDF
$pdf->writeHTML($tableHTML, true, false, false, false, '');

// Hapus output buffer sebelum mengirim file PDF
ob_end_clean();

// Output file PDF
$pdf->Output('daftar_prestasi.pdf', 'D');
exit;
?>
