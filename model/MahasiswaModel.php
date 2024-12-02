<?php
if (file_exists('../config/database.php')) {
    require_once '../config/database.php';
}

class MahasiswaModel
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->conn;
    }

    function getAllMahasiswa()
    {
        $query = "SELECT m.*, p.nama_prodi AS prodi FROM mahasiswa m JOIN prodi p ON m.id_prodi = p.id";
        // Mempersiapkan query
        $stmt = sqlsrv_query($this->db, $query);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $daftarMahasiswa = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $daftarMahasiswa[] = $row; // Menambahkan setiap baris data ke array
        }
        sqlsrv_free_stmt($stmt);

        return $daftarMahasiswa;
    }

    function updateBiodata($data)
    {
        $query = "UPDATE mahasiswa SET nama = ?, email = ?, no_telp = ? WHERE NIM = ?";
        $stmt = sqlsrv_prepare($this->db, $query, $data);
    }

    function changePassword($data)
    {
        $nim = $data['nim'];
        $newPassword = $data['newPassword'];
        $confirmPassword = $data['confirmPassword'];
        $currentPassword = $data['currentPassword'];

        // Menjalankan query untuk mengambil informasi pengguna berdasarkan username
        $query = "SELECT NIM, salt, password AS hashed_password FROM [mahasiswa] WHERE NIM = ?";
        $params = array($nim);
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
                        return $this->insertChangePassword($confirmPassword, $nim);
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

    function insertChangePassword($password, $nim)
    {
        $salt = bin2hex(random_bytes(16));

        // Menggabungkan password dengan salt
        $combined_password = $salt . $password;

        // Mengenkripsi password menggunakan bcrypt
        $hashed_password = password_hash($combined_password, PASSWORD_BCRYPT);

        // Query untuk memperbarui data mahasiswa
        $query = "UPDATE [mahasiswa] SET [password] = ?, [salt] = ? WHERE [NIM] = ?";
        $params = array($hashed_password, $salt, $nim);
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