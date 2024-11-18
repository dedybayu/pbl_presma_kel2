
document.addEventListener("DOMContentLoaded", function () {
    // Ambil semua elemen dengan class nav-link
    const navLinks = document.querySelectorAll('.nav-link');

    // Tetapkan default ke Dashboard jika tidak ada parameter "page"
    const currentPage = new URLSearchParams(window.location.search).get('page');
    const defaultLink = document.querySelector('a[href="index.php"]');

    if (!currentPage && defaultLink) {
        defaultLink.classList.add('active');
    }

    // Tambahkan event listener ke setiap elemen
    navLinks.forEach(link => {
        link.addEventListener('click', function () {
            // Hapus class active dari semua elemen
            navLinks.forEach(nav => nav.classList.remove('active'));

            // Tambahkan class active ke elemen yang diklik
            this.classList.add('active');
        });
    });

    // Tetapkan active berdasarkan URL (untuk navigasi selain Dashboard)
    navLinks.forEach(link => {
        const linkHref = link.getAttribute('href');
        if (linkHref.includes(`page=${currentPage}`)) {
            link.classList.add('active');
        }
    });
});

// Function to toggle sidebar visibility
function toggleSidebar() {
    var sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('active');
    var navbarTogglerIcon = document.querySelector('.navbar-toggler-icon');
    if (sidebar.classList.contains('active')) {
        navbarTogglerIcon.style.transform = 'scale(0.8)'; // Mengecilkan ikon saat sidebar terbuka
    } else {
        navbarTogglerIcon.style.transform = 'scale(1)'; // Kembalikan ukuran normal saat sidebar ditutup
    }
}

// Close sidebar when clicking outside of it
document.addEventListener("click", function (event) {
    var sidebar = document.getElementById("sidebar");
    var toggleButton = document.querySelector(".navbar-toggler");

    // Periksa apakah sidebar aktif dan klik di luar sidebar dan tombol toggle
    if (sidebar.classList.contains("active") && !sidebar.contains(event.target) && !toggleButton.contains(event.target)) {
        sidebar.classList.remove("active");
        toggleButton.querySelector(".navbar-toggler-icon").style.transform = "scale(1)"; // Kembalikan ukuran ikon toggle
    }
});

// Function to toggle dark mode
function toggleDarkMode() {
    var body = document.getElementById('body');
    var darkModeToggle = document.getElementById('darkModeToggle');

    // Toggle between light and dark mode classes
    body.classList.toggle('dark-mode');
    if (body.classList.contains('dark-mode')) {
        localStorage.setItem('theme', 'dark'); // Save preference
        darkModeToggle.textContent = 'Light Mode'; // Change button text
    } else {
        localStorage.setItem('theme', 'light'); // Save preference
        darkModeToggle.textContent = 'Dark Mode'; // Change button text
    }
}

// Check local storage for theme preference and apply it
window.onload = function () {

    var savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        document.getElementById('body').classList.add('dark-mode');
        document.getElementById('darkModeToggle').textContent = 'Light Mode'; // Set button text
    }
};

// Initialize DataTable
$(document).ready(function () {
    $('#example').DataTable();
});

