<?php
session_start();

// Cek jika tombol login ditekan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['level'])) {
        $_SESSION['level'] = $_POST['level']; // Set session level berdasarkan tombol yang dipilih
        header('Location: ../index.php'); // Redirect ke halaman utama
        exit();
    }
}
require_once "../model/PrestasiModel.php";
require_once "../model/MahasiswaModel.php";

$listPrestasi = new PrestasiModel();
$listMahasiswa = new MahasiswaModel();
$top3Prestasi = $listPrestasi->getTop3Prestasi();
$top10ahasiswa = $listMahasiswa->getTop10Mahasiswa();
?>

<?php

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>Prestasi Mahasiswa</title>

    <!-- CSS FILES -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/bootstrap-icons.css" rel="stylesheet">

    <link href="css/templatemo-ebook-landing.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <!--

TemplateMo 588 ebook landing

https://templatemo.com/tm-588-ebook-landing

-->
</head>

<body>

    <main>

        <nav class="navbar navbar-expand-lg">
            <div class="container">

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-lg-auto me-lg-4">
                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="#section_1">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="#section_2">Tentang Kami</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="#section_3">Prestasi Mahasiswa Terbaik</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="#section_4">Daftar Mahasiswa Terbaik</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        <section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
            <div class="container">
                <div class="row">

                    <div class="col-lg-6 col-12 mb-5 pb-5 pb-lg-0 mb-lg-0">

                        <h6>Prestasi Core</h6>

                        <h1 class="text-white mb-4">Sistem Pencatatan Prestasi Mahasiswa</h1>

                        <div class="d-flex justify-content-center align-items-center gap-3">
                            <p class="text-light mb-0">Masuk sebagai:</p>
                        </div>

                        <div class="d-flex justify-content-center gap-3 mt-3">
                            <form method="POST" action="">
                                <button type="submit" name="level" value="mahasiswa"
                                    class="btn btn-primary">Mahasiswa</button>
                                <button type="submit" name="level" value="dosen"
                                    class="btn btn-secondary">Dosen</button>
                                <button type="submit" name="level" value="admin" class="btn btn-success">Admin</button>
                            </form>
                        </div>



                    </div>



                </div>
            </div>
        </section>


        <section class="footer-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <p>&copy; 2024 <strong>Sistem Pencatatan Prestasi Mahasiswa</strong>. All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </section>




        <section class="py-lg-5"></section>


        <section class="book-section section-padding" id="section_2">
            <div class="container">
                <div class="row">

                    <div class="col-lg-6 col-12">
                        <img src="images/prestasi mahasiswa 3.png" class="img-fluid" alt="">
                    </div>

                    <div class="col-lg-6 col-12">
                        <div class="book-section-info">

                            <h2 class="mb-4">Sistem Pencatatan Prestasi Mahasiswa</h2>

                            <p>
                                Sistem ini hadir untuk membantu mahasiswa dalam mencatat dan mengelola berbagai prestasi
                                yang telah diraih, di bidang non-akademik.
                                Dengan fitur yang mudah digunakan, sistem ini memungkinkan setiap mahasiswa untuk
                                mendokumentasikan pencapaian secara rapi, terstruktur, dan terpusat.
                                Selain itu, sistem ini dirancang agar data prestasi dapat diakses dengan cepat dan
                                menjadi portofolio yang dapat mendukung pengembangan karier maupun akademik Anda.
                                Mari wujudkan potensi terbaik dan raih masa depan gemilang bersama!
                            </p>

                            <p>
                                Sistem pencatatan prestasi mahasiswa bertujuan untuk mencatat dan mengelola prestasi di
                                luar bidang akademik,
                                seperti kegiatan olahraga, seni, organisasi, lomba, atau kontribusi lainnya. Dengan
                                sistem ini, Anda dapat mendokumentasikan setiap pencapaian dengan mudah dan
                                terorganisir, sehingga dapat digunakan sebagai portofolio untuk pengembangan diri dan
                                karier.
                                Jadikan setiap langkah Anda bermakna, dan raih lebih banyak peluang melalui prestasi
                                non-akademik yang membanggakan!
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <br><br>
        <!-- Prestasi Terbaik Section -->
        <section class="prestasi-section" id="section_3">
            <div class="container">
                <h2 class="text-center mb-4">Prestasi Terbaik Mahasiswa</h2>
                <div class="slider-container">
                    <!-- Panah Navigasi -->
                    <button class="arrow left" onclick="moveSlide('prev')">&#8249;</button>
                    <button class="arrow right" onclick="moveSlide('next')">&#8250;</button>

                    <div class="slider-container">
                        <div class="slides">

                            <?php
                            foreach ($top3Prestasi as $prestasi) {
                                ?>
                                <div class="slide">
                                    <?php
                                    echo '<img src="data:image/jpeg;base64,' . base64_encode($prestasi['file_bukti_foto']) . '" alt="Foto Prestasi" data-title="Foto Saat Perlombaan">';
                                    ?>
                                    <div class="details">
                                        <p><strong>JUARA 1 MENANAM BAYAM</strong></p>
                                        <table>
                                            <tr>
                                                <td>Nama Mahasiswa</td>
                                                <td>: <?= $prestasi['nama'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Tingkat</td>
                                                <td>: <?= ucfirst(strtolower($prestasi['tingkat_lomba'])); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Jenis Lomba</td>
                                                <td>: <?= $prestasi['jenis_lomba'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Penyelenggara</td>
                                                <td>: <?= $prestasi['penyelenggara_lomba'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Tempat</td>
                                                <td>: <?= $prestasi['tempat_pelaksanaan'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Waktu Pelaksanaan</td>
                                                <td>: <?= $prestasi['waktu_pelaksanaan']->format('j F Y'); ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>


                    <section class="daftar-section" id="section_4"></section>
                    <!-- Tabel Daftar Mahasiswa dengan Prestasi Terbaik -->
                    <h3 class="text-center mb-4">Daftar Mahasiswa dengan Prestasi Terbaik</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Nama Mahasiswa</th>
                                <th>Jumlah Prestasi</th>
                                <th>Poin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($top10ahasiswa as $mahasiswa) {
                                ?>
                                <tr>
                                    <td><?= $mahasiswa['rank'] ?></td>
                                    <td><?= $mahasiswa['nama'] ?></td>
                                    <td><?= $mahasiswa['total_prestasi'] ?></td>
                                    <td><?= $mahasiswa['total_poin'] ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td>2</td>
                                <td>Budi Santoso</td>
                                <td>Juara 1 Menanam Cabai</td>
                                <td>28 Oktober 2030</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Joko Widodo</td>
                                <td>Juara 2 Menanam Tomat</td>
                                <td>29 Oktober 2030</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Siti Aminah</td>
                                <td>Juara 3 Menanam Cabai</td>
                                <td>30 Oktober 2030</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Rina Pramesti</td>
                                <td>Juara 1 Menanam Terong</td>
                                <td>31 Oktober 2030</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Agus Setiawan</td>
                                <td>Juara 2 Menanam Bayam</td>
                                <td>1 November 2030</td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Diana Putri</td>
                                <td>Juara 3 Menanam Terong</td>
                                <td>2 November 2030</td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>Rudi Hartono</td>
                                <td>Juara 1 Menanam Sawi</td>
                                <td>3 November 2030</td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>Fajar Nugroho</td>
                                <td>Juara 2 Menanam Sawi</td>
                                <td>4 November 2030</td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>Wati Sukma</td>
                                <td>Juara 3 Menanam Tomat</td>
                                <td>5 November 2030</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
        </section>






    </main>

    <!-- JAVASCRIPT FILES -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/click-scroll.js"></script>
    <script src="js/custom.js"></script>

    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');
        const totalSlides = slides.length;

        function moveSlide(direction) {
            if (direction === 'next') {
                currentSlide = (currentSlide + 1) % totalSlides;
            } else if (direction === 'prev') {
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            }
            const slidesContainer = document.querySelector('.slides');
            slidesContainer.style.transform = `translateX(-${currentSlide * 100}%)`;
        }

    </script>

</body>

</html>