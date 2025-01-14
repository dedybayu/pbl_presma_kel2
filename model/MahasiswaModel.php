<?php
if (file_exists('../config/database.php')) {
    require_once '../config/database.php';
}
// include '../fungsi/anti_injection.php';



class MahasiswaModel
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->conn;
    }

    function addMahasiswa($data)
    {
        $password = $data['nim'];
        $salt = bin2hex(random_bytes(16));
        $combined_password = $salt . $password;
        $hashed_password = password_hash($combined_password, PASSWORD_BCRYPT);

        $query = "INSERT INTO [mahasiswa] (NIM, password, salt, nama, jenis_kelamin, id_prodi, email, no_tlp) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $params = array($data['nim'], $hashed_password, $salt, $data['nama'], $data['jenis_kelamin'], $data['prodi'], $data['email'], $data['no_tlp']);
        $stmt = sqlsrv_query($this->db, $query, $params);

        if ($stmt === false) {
            return false;
        } else {
            return true;
        }
    }

    function addMahasiswaByExcel($data)
    {
        foreach ($data as $row) {
            $password = $row['nim'];
            $salt = bin2hex(random_bytes(16));
            $combined_password = $salt . $password;
            $hashed_password = password_hash($combined_password, PASSWORD_BCRYPT);

            $query = "INSERT INTO [mahasiswa] (NIM, password, salt, nama, jenis_kelamin, id_prodi, email, no_tlp) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $params = array($row['nim'], $hashed_password, $salt, $row['nama'], $row['jenis_kelamin'], $row['prodi'], $row['email'], $row['no_tlp']);
            $stmt = sqlsrv_query($this->db, $query, $params);

            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }
        }
        return true;
    }

    function deleteMahasiswa($nim)
    {
        $query = "DELETE FROM [mahasiswa] WHERE NIM = '$nim'";
        $stmt = sqlsrv_query($this->db, $query);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));

            // return false;

        } else {
            return true;
        }
    }

    function getMahasiswaByNim($nim)
    {
        $nim = antiinjection($nim);
        $query = "SELECT 
                m.*, 
                p.nama_prodi AS prodi 
            FROM 
                mahasiswa m
            JOIN 
                prodi p ON m.id_prodi = p.id
            WHERE 
                m.NIM = ?;";
        $params = array($nim);
        // Mempersiapkan query
        $stmt = sqlsrv_query($this->db, $query, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $mahasiswa = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        sqlsrv_free_stmt($stmt);

        return $mahasiswa;
    }

    public function getTop10Mahasiswa(): array
    {
        $query =
            "WITH CTE_TotalPrestasi AS (
            SELECT 
                m.nama, 
                SUM(p.poin) AS total_poin,
                COUNT(p.id) AS total_prestasi
            FROM mahasiswa m
            LEFT JOIN prestasi p ON m.NIM = p.NIM
            WHERE p.status_verifikasi = 'valid'
            GROUP BY m.NIM, m.nama
        )
        SELECT TOP 10 
            ROW_NUMBER() OVER (ORDER BY total_poin DESC) AS rank,
            nama,
            total_poin,
            total_prestasi
        FROM CTE_TotalPrestasi
        ORDER BY total_poin DESC;";

        $stmt = sqlsrv_query($this->db, $query);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $mahasiswa = [];

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $mahasiswa[] = $row;
        }
        sqlsrv_free_stmt($stmt);

        return $mahasiswa;
    }

    function getAllMahasiswa()
    {
        // $query = "SELECT m.*, p.nama_prodi AS prodi FROM mahasiswa m JOIN prodi p ON m.id_prodi = p.id";
        $query = "WITH CTE_TotalPrestasi AS (
            SELECT 
                m.NIM,
                m.nama,
                m.jenis_kelamin,
                m.email,
                m.no_tlp,
                p.nama_prodi AS prodi,
                SUM(COALESCE(pr.poin, 0)) AS total_poin,
                COUNT(pr.id) AS total_prestasi
            FROM mahasiswa m
            LEFT JOIN prestasi pr 
                ON m.NIM = pr.NIM AND pr.status_verifikasi = 'valid'
            INNER JOIN prodi p 
                ON m.id_prodi = p.id
            GROUP BY 
                m.NIM, 
                m.nama, 
                m.jenis_kelamin, 
                m.email, 
                m.no_tlp, 
                p.nama_prodi
        )
        SELECT 
            ROW_NUMBER() OVER (ORDER BY total_poin DESC) AS rank,
            NIM,
            nama,
            prodi,
            jenis_kelamin,
            email,
            no_tlp,
            total_poin,
            total_prestasi
        FROM CTE_TotalPrestasi
        ORDER BY nama ASC;
        ";



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

    function getRankAndPoin($nim)
    {
        $query = "WITH TotalPoin AS (
                SELECT
                    m.NIM,
                    m.nama,
                    SUM(p.poin) AS total_poin
                FROM
                    mahasiswa m
                JOIN
                    prestasi p ON m.NIM = p.NIM
                WHERE
                    p.status_verifikasi = 'valid'
                GROUP BY
                    m.NIM, m.nama
            ),
            Ranking AS (
                SELECT
                    NIM,
                    nama,
                    total_poin,
                    RANK() OVER (ORDER BY total_poin DESC) AS ranking
                FROM
                    TotalPoin
            )
            SELECT
                ranking,
                NIM,
                nama,
                total_poin
            FROM
                Ranking
            WHERE
                NIM = ?";

        $params = array($nim);
        // Mempersiapkan query
        $stmt = sqlsrv_query($this->db, $query, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        sqlsrv_free_stmt($stmt);

        return $row;
    }


    function updateDataMahasiswa($data)
    {
        $query = "UPDATE mahasiswa SET NIM = ?, nama = ?, jenis_kelamin = ?, id_prodi = ?, email = ?, no_tlp = ?, file_foto_profile = ISNULL(CONVERT(VARBINARY(MAX), ?), file_foto_profile) WHERE NIM = ?";
        $stmt = sqlsrv_query($this->db, $query, $data);
        if ($stmt === false) {
            // return false;
            die(print_r(sqlsrv_errors(), true));

        } else {
            return true;
        }

    }

    function updateBiodata($data)
    {
        $query = "UPDATE mahasiswa SET email = ?, no_tlp = ?, file_foto_profile = ISNULL(CONVERT(VARBINARY(MAX), ?), file_foto_profile) WHERE NIM = ?";
        $stmt = sqlsrv_query($this->db, $query, $data);
        if ($stmt === false) {
            return false;
        } else {
            return true;
        }

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
            die(print_r(sqlsrv_errors(), return: true));
        }

        // Eksekusi query
        if (!sqlsrv_execute($stmt)) {
            die(print_r(sqlsrv_errors(), true));
        }

        sqlsrv_free_stmt($stmt); // Bebaskan memori

        return "Password berhasil diubah.";
    }

    function getMahasiswaByDosbim($nip)
    {
        $query = "WITH TotalPrestasi AS (
        SELECT 
            m.NIM,
            COUNT(pr.id) AS total_prestasi_valid,
            SUM(pr.poin) AS total_poin
        FROM mahasiswa m
        JOIN prestasi pr ON m.NIM = pr.NIM
        WHERE pr.status_verifikasi = 'valid'
        GROUP BY m.NIM
        ),
        Ranking AS (
            SELECT 
                NIM,
                total_poin,
                RANK() OVER (ORDER BY total_poin DESC) AS ranking
            FROM TotalPrestasi
        )
        SELECT DISTINCT 
            m.*,
            p.nama_prodi,
            ISNULL(tp.total_poin, 0) AS total_poin,
            ISNULL(tp.total_prestasi_valid, 0) AS total_prestasi_valid,
            ISNULL(r.ranking, NULL) AS ranking
        FROM mahasiswa m
        JOIN prodi p ON m.id_prodi = p.id
        LEFT JOIN TotalPrestasi tp ON m.NIM = tp.NIM
        LEFT JOIN Ranking r ON m.NIM = r.NIM
        JOIN prestasi pr ON m.NIM = pr.NIM
        WHERE pr.nip_dosbim = ?
        ORDER BY m.nama ASC;
        ";

        $params = array($nip);
        $stmt = sqlsrv_query($this->db, $query, $params);

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

}