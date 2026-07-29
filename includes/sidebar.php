<div class="sidebar">

    <div class="logo">

        <img src="/inventaris-ti-dispusipda/assets/img/logo.png" alt="Logo">

        <div>
            <h3>DISPUSIPDA</h3>
            <small>Inventaris TI</small>
        </div>

    </div>

    <div class="menu-title">
        MENU UTAMA
    </div>

    <ul class="menu">

        <li>
            <a href="/inventaris-ti-dispusipda/dashboard.php">
                <i class="fa-solid fa-house"></i>
                Dashboard
            </a>
        </li>

        <li>
            <a href="/inventaris-ti-dispusipda/pages/inventaris/index.php">
                <i class="fa-solid fa-computer"></i>
                Inventaris
            </a>
        </li>

        <li>
            <a href="/inventaris-ti-dispusipda/pages/maintenance/index.php">
                <i class="fa-solid fa-screwdriver-wrench"></i>
                Maintenance
            </a>
        </li>

        <li>
            <a href="/inventaris-ti-dispusipda/pages/peminjaman/index.php">
                <i class="fa-solid fa-right-left"></i>
                Peminjaman
            </a>
        </li>

        <li>
            <a href="/inventaris-ti-dispusipda/pages/laporan/index.php">
                <i class="fa-solid fa-chart-column"></i>
                Laporan
            </a>
        </li>

    </ul>

    <div class="sidebar-footer">

        <div class="user">

            <div class="avatar">
                <i class="fa-solid fa-user"></i>
            </div>

            <div>
                <h4><?= htmlspecialchars($_SESSION['nama']); ?></h4>
                <span>Administrator</span>
            </div>

        </div>

        <a href="/inventaris-ti-dispusipda/logout.php" class="logout">

            <i class="fa-solid fa-arrow-right-from-bracket"></i>

            Keluar Sistem

        </a>

    </div>

</div>