// document.addEventListener("DOMContentLoaded", function () {
//     // Ambil semua elemen dengan class sidebar-class
//     const navLinks = document.querySelectorAll('.sidebar-class');

//     // Ambil parameter "page" dari URL
//     const currentPage = new URLSearchParams(window.location.search).get('page');

//     // Tetapkan class active berdasarkan URL
//     navLinks.forEach(link => {
//         const linkHref = link.getAttribute('href');
        
//         // Jika href tidak memiliki parameter page, anggap itu adalah halaman default (dashboard)
//         if (!currentPage && linkHref === "index.php") {
//             link.classList.add('active');
//         } else {
//             // Ambil nilai page dari href link
//             const pageValue = new URLSearchParams(linkHref.split('?')[1]).get('page');

//             // Jika currentPage sama dengan pageValue, tambahkan class active
//             if (currentPage === pageValue) {
//                 link.classList.add('active');
//             }
//         }
//     });
// });


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

