<?php
    function set_flashdata($key = "", $value = "") {
        if (!empty($key) && !empty($value)) {
            $_SESSION['_flashdata'][$key] = $value;
            return true;
        }
        return false;
    }

    function get_flashdata($key = "") {
        if (!empty($key) && isset($_SESSION['_flashdata'][$key])) {
            $data = $_SESSION['_flashdata'][$key];
            unset($_SESSION['_flashdata'][$key]);
            return $data;
        }
        return null; // Kembalikan null jika pesan tidak ada
    }

    function pesan() {
        // Set pesan flash sederhana
        set_flashdata('info', "Username atau Password salah!");
    }
?>
