<?php
session_start();

// Cek jika tombol login ditekan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['level'])) {
        $_SESSION['level'] = $_POST['level']; // Set session level berdasarkan tombol yang dipilih
        header('Location: index.php'); // Redirect ke halaman utama
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }
        .login-container {
            text-align: center;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .login-container h1 {
            margin-bottom: 20px;
            color: #333;
        }
        .login-btn {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-mahasiswa {
            background-color: #007bff;
        }
        .btn-dosen {
            background-color: #28a745;
        }
        .btn-admin {
            background-color: #dc3545;
        }
        .login-btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login Sebagai</h1>
        <form method="POST" action="">
            <button type="submit" name="level" value="mahasiswa" class="login-btn btn-mahasiswa">Mahasiswa</button>
            <button type="submit" name="level" value="dosen" class="login-btn btn-dosen">Dosen</button>
            <button type="submit" name="level" value="admin" class="login-btn btn-admin">Admin</button>
        </form>
    </div>
</body>
</html>
