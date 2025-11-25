<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />
<title>@yield('title', 'Website Desa Jenangan')</title>

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/scrollreveal"></script>
<!-- Boxicons (icons used across landing pages) -->
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
<!-- Tailwind CSS Customization -->
<style>
    /* Navbar styles */
    .navbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 10;
    transition: all 0.3s ease;
    }

    .navbar.transparent {
    background-color: transparent;
    box-shadow: none;
    }

    .navbar.scrolled {
    background-color: #1a202c;
    padding: 10px 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .navbar-logo-img {
    transition: all 0.3s ease;
    }

    .navbar-logo-img.large {
    width: 3rem;
    height: 3rem;
    }

    .navbar-logo-img.small {
    width: 2.5rem;
    height: 2.5rem;
    }

    .navbar-text {
    transition: all 0.3s ease;
    }

    .navbar-text.large {
    font-size: 1.25rem;
    }

    .navbar-text.small {
    font-size: 1rem;
    }

    /* Dropdown Menu */
    .dropdown-menu {
    display: none;
    position: absolute;
    background-color: rgba(26, 32, 44, 0.9);
    color: white;
    z-index: 20;
    border-radius: 0.5rem;
    padding: 0.5rem 0;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .dropdown-menu a {
    display: block;
    padding: 0.5rem 1rem;
    text-decoration: none;
    color: white;
    }

    .dropdown-menu a:hover {
    background-color: rgba(255, 255, 255, 0.2);
    }

    .dropdown.active .dropdown-menu {
    display: block;
    }
    /* Mobile dropdown-menu styling */
    #mobile-menu .dropdown-menu {
    z-index: 20; /* Tambahkan z-index yang lebih tinggi */
    }

    #mobile-menu .dropdown-menu.hidden {
    display: none;
    }

    #mobile-menu .dropdown-menu:not(.hidden) {
    display: block;
    }

    /* Hero section */
    .hero {
    height: 100vh;
    position: relative;
    overflow: hidden;
    }

    .hero-images {
    display: flex;
    transition: transform 1s ease-in-out;
    }

    .hero-image {
    min-width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    }

    .hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    z-index: 1;
    }

    .hero-content {
    position: absolute;
    z-index: 2;
    color: white;
    text-align: center;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    }

    /* Logo section */
    #logo-section {
    z-index: 8;
    visibility: hidden;
    }

/* Logo Section - Mobile */
@media (max-width: 768px) {
    #logo-section {
        bottom: -101px; /* Menurunkan posisi logo sedikit lebih rendah */
        transform: translateX(-50%) translateY(10%); /* Menurunkan logo lebih jauh pada perangkat mobile */
    }
}

/* Logo Section - Tablet */
@media (min-width: 769px) and (max-width: 1024px) {
    #logo-section {
        bottom: -90px; /* Menurunkan posisi logo sedikit lebih rendah */
        transform: translateX(-50%) translateY(5%); /* Menyesuaikan posisi logo untuk tablet */
    }
}
/* Logo Section - Tablet */
@media (min-width: 100px) and (max-width: 1024px) {
    #logo-section {
        bottom: -50px; /* Menurunkan posisi logo sedikit lebih rendah */
        transform: translateX(-50%) translateY(5%); /* Menyesuaikan posisi logo untuk tablet */
    }
}


    /* Mobile menu */
    #mobile-menu {
    position: fixed;
    left: 0;
    width: 100%;
    z-index: 10;
    top: 4.5rem; /* Default top position when navbar is not scrolled */
    }
    .navbar-text.active {
        position: relative;
    }
    .navbar-text.active::after {
        content: '';
        position: absolute;
        bottom: -4px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: #1e90ff; /* Warna biru */
    }
    .dropdown-menu a.active::after {
        content: '';
        position: absolute;
        bottom: -4px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: #1e90ff; /* Warna biru */
    }
</style>
<!-- Countdown Timer Script -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
