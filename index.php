<?php



if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Memastikan sesi sudah dimulai
}

if (!empty($_SESSION['level'])) { // Cek jika session level ada dan tidak kosong
    if ($_SESSION['level'] == 'mahasiswa') {
        // Kode untuk mahasiswa
        if (!empty($_SESSION['nim'])) {
            require 'config/database.php';
            require 'fungsi/pesan_kilat.php';

            include 'page/template/header.php';
            if (!empty($_GET['page'])) {
                if ($_GET['page'] === "editprestasi") {
                    $_SESSION['page'] = "daftarprestasi";
                } else {
                    $_SESSION['page'] = $_GET['page'];
                }
                include 'page/template/sidebar_mhs.php';
                include 'page/mahasiswa/' . $_GET['page'] . '/index.php';
            } else {
                $_SESSION['page'] = "dashboard";
                include 'page/template/sidebar_mhs.php';
                include 'page/mahasiswa/index.php';
            }
            include 'page/template/footer.php';
            exit();
        } else {
            header("Location: login_mahasiswa.php");
            exit();
        }
    } elseif ($_SESSION['level'] == 'admin') {
        // Kode untuk admin
        if (!empty($_SESSION['username'])) {
            require 'config/database.php';
            require 'fungsi/pesan_kilat.php';
        
            include 'page/template/header.php';
            include 'page/template/sidebar_admin.php';
            if (!empty($_GET['page'])) {
                include 'page/admin/' . $_GET['page'] . '/index.php';
            } else {
                include 'page/admin/index.php';
            }
            include 'page/template/footer.php';
            exit();
        } else {
            header("Location: login_admin.php");
            exit();
        }
    } elseif ($_SESSION['level'] == 'dosen') {
        // Kode untuk dosen
        // Kode untuk admin
        if (!empty($_SESSION['nip'])) {
            require 'config/database.php';
            require 'fungsi/pesan_kilat.php';
        
            include 'page/template/header.php';
            include 'page/template/sidebar_dosen.php';
            if (!empty($_GET['page'])) {
                include 'page/dosen/' . $_GET['page'] . '/index.php';
            } else {
                include 'page/dosen/index.php';
            }
            include 'page/template/footer.php';
            exit();
        } else {
            header("Location: login_dosen.php");
            exit();
        }
    }
} else {
    header("Location: landing_page.php");
}




// if (!empty($_SESSION['nim'])) {
//     require 'config/database.php';
//     require 'fungsi/pesan_kilat.php';

//     include 'page/template/header.php';
//     include 'page/template/sidebar_mhs.php';
//     if (!empty($_GET['page'])) {
//         include 'page/mahasiswa/' . $_GET['page'] . '/index.php';
//     } else {
//         include 'page/mahasiswa/index.php';
//     }
//     include 'page/template/footer.php';
//     exit();
// }  else {
//     header("Location: login.php");
//     exit();
// }














// if (!empty($_SESSION['level'])) { // Cek jika session level ada dan tidak kosong
//     if ($_SESSION['level'] == 'mahasiswa') {
//         // Kode untuk mahasiswa
//         if (!empty($_SESSION['nim'])) {
//             require 'config/database.php';
//             require 'fungsi/pesan_kilat.php';

//             include 'page/template/header.php';
//             include 'page/template/sidebar_mhs.php';
//             if (!empty($_GET['page'])) {
//                 include 'page/mahasiswa/' . $_GET['page'] . '/index.php';
//             } else {
//                 include 'page/mahasiswa/index.php';
//             }
//             include 'page/template/footer.php';
//             exit();
//         } else {
//             header("Location: login.php");
//             exit();
//         }
//     } elseif ($_SESSION['level'] == 'admin') {
//         // Kode untuk admin
//         if (!empty($_SESSION['username'])) {
//             require 'config/database.php';
//             require 'fungsi/pesan_kilat.php';
        
//             include 'page/template/header.php';
//             include 'page/template/sidebar_admin.php';
//             if (!empty($_GET['page'])) {
//                 include 'page/admin/' . $_GET['page'] . '/index.php';
//             } else {
//                 include 'page/admin/index.php';
//             }
//             include 'page/template/footer.php';
//             exit();
//         } else {
//             header("Location: login.php");
//             exit();
//         }
//     } elseif ($_SESSION['level'] == 'dosen') {
//         // Kode untuk dosen
//         // Tambahkan kode untuk dosen di sini
//     }
// } else {
//     // Tidak ada session level, arahkan ke halaman login
//     header("Location: login.php");
//     exit();
// }




// if (!empty($_SESSION['nim'])) {
//     header("Location: dashboard/");
//     exit();
// } else {
//     header("Location: login.php");
//     exit();
// }


?>