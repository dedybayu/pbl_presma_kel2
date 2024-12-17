<?php
require_once '../model/AdminModel.php';
include '../fungsi/anti_injection.php';
$admin = new AdminModel();
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['action'] === 'change_password'){
        $username = antiinjection($_POST['username']);
        $newUsername = antiinjection($_POST['new_username']);
        $password = antiinjection($_POST['password']);

        $status = $admin->changePassword($newUsername, $password, $username);

        if ($status === "Password berhasil diubah.") {
            $_SESSION['success_message'] = "Password Berhasil Diubah";
        } else {
            $_SESSION['error_message'] = "Gagal Merubah Password";
        }
        $_SESSION['temp_nim'] = $nim;
        header("Location: ../index.php?page=setting");
    }

}