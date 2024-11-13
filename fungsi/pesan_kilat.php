<?php
    function set_flashdata($key = "", $value = ""){
        if (!empty($key) && !empty($value)) {
            $_SESSION['_flashdata'][$key] = $value;
            return true;
        }
        return false;
    }

    function get_flashdata($key = ""){
        if (!empty($key) && isset($_SESSION['_flashdata'][$key])) {
            $data = $_SESSION['_flashdata'][$key];
            unset($_SESSION['_flashdata'][$key]);
            return $data;
        } else {
            echo "<script> alert(' Flash Message \'{$key}\' is not defined. ')</script>";
        }
    }

    function pesan($key = "", $pesan =""){
        if ($key == "info") {
            set_flashdata('info', "<div class='alert alert-primary alert-dimissible fade show' role='alert'>
                    <strong>Info! </strong> {$pesan}
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>               
            </div>");
        } elseif ($key == "success") {
            set_flashdata('info', "<div class='alert alert-success alert-dimissible fade show' role='alert'>
                    <strong>Info! </strong> {$pesan}
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>               
            </div>");
        } elseif ($key == "danger") {
            set_flashdata('info', "<div class='alert alert-danger alert-dimissible fade show' role='alert'>
                    <strong>Info! </strong> {$pesan}
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>               
            </div>");
        } elseif ("warning") {
            set_flashdata('info', "<div class='alert alert-warning alert-dimissible fade show' role='alert'>
                    <strong>Info! </strong> {$pesan}
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>               
            </div>");
        }
    }
?>