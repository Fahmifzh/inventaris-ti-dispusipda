<aside class="sidebar" id="sidebar">

    <div class="logo">
        <img src="/inventaris-ti-dispusipda/assets/img/logo.png" alt="Logo">
        <div>
            <h3>DISPUSIPDA</h3>
            <small>Inventaris TI</small>
        </div>
    </div>

    <div class="menu-wrap">

        <div class="menu-title">
            MENU UTAMA
        </div>

        <ul class="menu">

            <li class="<?= (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : '' ?>">
                <a href="/inventaris-ti-dispusipda/dashboard.php">
                    <i class="fa-solid fa-house"></i>
                    Dashboard
                </a>
            </li>

            <li class="<?= (strpos($_SERVER['REQUEST_URI'], '/pages/inventaris/') !== false) ? 'active' : '' ?>">
                <a href="/inventaris-ti-dispusipda/pages/inventaris/index.php">
                    <i class="fa-solid fa-computer"></i>
                    Inventaris
                </a>
            </li>

            <li class="<?= (strpos($_SERVER['REQUEST_URI'], '/pages/maintenance/') !== false) ? 'active' : '' ?>">
                <a href="/inventaris-ti-dispusipda/pages/maintenance/index.php">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    Maintenance
                </a>
            </li>

            <li class="<?= (strpos($_SERVER['REQUEST_URI'], '/pages/peminjaman/') !== false) ? 'active' : '' ?>">
                <a href="/inventaris-ti-dispusipda/pages/peminjaman/index.php">
                    <i class="fa-solid fa-right-left"></i>
                    Peminjaman
                </a>
            </li>

            <li class="<?= (strpos($_SERVER['REQUEST_URI'], '/pages/laporan/') !== false) ? 'active' : '' ?>">
                <a href="/inventaris-ti-dispusipda/pages/laporan/index.php">
                    <i class="fa-solid fa-chart-column"></i>
                    Laporan
                </a>
            </li>

        </ul>

    </div>

</aside>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>