<?php
require_once '../model/PrestasiModel.php';

class PrestasiController
{
    private $model;

    public function __construct()
    {
        $this->model = new PrestasiModel();
    }

    public function addPrestasi($data, $files)
    {
        try {
            // Validasi dan olah data
            $data['file_bukti_foto'] = file_get_contents($files['foto_lomba']['tmp_name']);
            $data['file_sertifikat'] = file_get_contents($files['sertifikat']['tmp_name']);
            $data['file_surat_undangan'] = !empty($files['suratUndangan']['tmp_name']) ? file_get_contents($files['suratUndangan']['tmp_name']) : null;
            $data['file_surat_tugas'] = !empty($files['suratTugas']['tmp_name']) ? file_get_contents($files['suratTugas']['tmp_name']) : null;
            $data['file_proposal'] = !empty($files['proposal']['tmp_name']) ? file_get_contents($files['proposal']['tmp_name']) : null;

            // Kalkulasi poin
            $data['poin'] = $this->calculatePoints($data['tingkat_lomba'], $data['juara_lomba']);

            // Tambah waktu upload
            $data['upload_date'] = date('Y-m-d H:i');

            // Susun parameter untuk query
            $params = [
                $data['nim'],
                $data['nama_lomba'],
                $data['dosbim'],
                $data['jenis_lomba'],
                $data['juara_lomba'],
                $data['tingkat_lomba'],
                $data['waktu_lomba'],
                $data['tempat_lomba'],
                $data['penyelenggara_lomba'],
                $data['file_bukti_foto'],
                $data['file_sertifikat'],
                $data['file_surat_undangan'],
                $data['file_surat_tugas'],
                $data['file_proposal'],
                $data['poin'],
                $data['upload_date']
            ];

            $this->model->insertPrestasi($params);

            header("Location: ../index.php?page=daftarprestasi");
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    private function calculatePoints($tingkatLomba, $juaraLomba)
    {
        $points = 0;
        if ($tingkatLomba == 'internasional') {
            $points = match ($juaraLomba) {
                '1' => 100,
                '2' => 90,
                '3' => 80,
                default => 50
            };
        } elseif ($tingkatLomba == 'nasional') {
            $points = match ($juaraLomba) {
                '1' => 80,
                '2' => 70,
                '3' => 60,
                default => 30
            };
        } elseif ($tingkatLomba == 'regional') {
            $points = match ($juaraLomba) {
                '1' => 60,
                '2' => 50,
                '3' => 40,
                default => 10
            };
        }
        return $points;
    }


}
