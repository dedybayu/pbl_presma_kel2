<?php
if (file_exists('../config/database.php')) {
    require_once '../config/database.php';
}

class DosenModel
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->conn;
    }

    function getAllDosen()
    {
        $query = "SELECT * FROM dosen";
        // Mempersiapkan query
        $stmt = sqlsrv_query($this->db, $query);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $daftarDosen = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $daftarDosen[] = $row; // Menambahkan setiap baris data ke array
        }
        sqlsrv_free_stmt($stmt);

        return $daftarDosen;
    }

    function changePassword($data)
    {
        $nip = $data['nip'];
        $newPassword = $data['newPassword'];
        $confirmPassword = $data['confirmPassword'];
        $currentPassword = $data['currentPassword'];

        // Menjalankan query untuk mengambil informasi pengguna berdasarkan username
        $query = "SELECT nip, salt, password AS hashed_password FROM [dosen] WHERE nip = ?";
        $params = array($nip);
        $stmt = sqlsrv_query($this->db, $query, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        // Mengambil hasil query
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        sqlsrv_free_stmt($stmt); // Bebaskan memori

        if ($row) {
            $salt = $row['salt'];
            $hashed_password = $row['hashed_password'];

            // Validasi password
            if ($salt !== null && $hashed_password !== null) {
                $combined_password = $salt . $currentPassword;

                if (password_verify($combined_password, $hashed_password)) {
                    if ($newPassword === $confirmPassword) {
                        return $this->insertChangePassword($confirmPassword, $nip);
                    } else {
                        return "Password baru dan konfirmasi tidak cocok.";
                    }
                } else {
                    return "Password Lama Salah";
                }
            }
        }

        return "User tidak ditemukan.";
    }

    function updateBiodata($data)
    {
        $query = "UPDATE dosen SET email = ?, no_tlp = ?, file_foto_profile = ISNULL(CONVERT(VARBINARY(MAX), ?), file_foto_profile) WHERE nip = ?";
        $stmt = sqlsrv_query($this->db, $query, $data);
        if ($stmt === false) {
            return false;
        } else {
            return true;
        }

    }

    function insertChangePassword($password, $nip)
    {
        $salt = bin2hex(random_bytes(16));

        // Menggabungkan password dengan salt
        $combined_password = $salt . $password;

        // Mengenkripsi password menggunakan bcrypt
        $hashed_password = password_hash($combined_password, PASSWORD_BCRYPT);

        // Query untuk memperbarui data mahasiswa
        $query = "UPDATE [dosen] SET [password] = ?, [salt] = ? WHERE [nip] = ?";
        $params = array($hashed_password, $salt, $nip);
        $stmt = sqlsrv_prepare($this->db, $query, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        // Eksekusi query
        if (!sqlsrv_execute($stmt)) {
            die(print_r(sqlsrv_errors(), true));
        }

        sqlsrv_free_stmt($stmt); // Bebaskan memori

        return "Password berhasil diubah.";
    }
}