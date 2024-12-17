<?php
if (file_exists('../config/database.php')) {
    require_once '../config/database.php';
}

class AdminModel
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->conn;
    }

    function changePassword($newUsername, $password, $username){
        $salt = bin2hex(random_bytes(16));

        // Menggabungkan password dengan salt
        $combined_password = $salt . $password;

        // Mengenkripsi password menggunakan bcrypt
        $hashed_password = password_hash($combined_password, PASSWORD_BCRYPT);

        // Query untuk memperbarui data mahasiswa
        $query = "UPDATE [admin] SET [username] = ?, [password] = ?, [salt] = ? WHERE [username] = ?";
        $params = array($newUsername, $hashed_password, $salt, $username);
        $stmt = sqlsrv_prepare($this->db, $query, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), return: true));
        }

        // Eksekusi query
        if (!sqlsrv_execute($stmt)) {
            die(print_r(sqlsrv_errors(), true));
        }

        sqlsrv_free_stmt($stmt); // Bebaskan memori

        return "Password berhasil diubah.";
    }
}