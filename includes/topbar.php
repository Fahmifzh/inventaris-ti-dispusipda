<?php
/**
 * TOPBAR - Reusable untuk semua halaman
 * 
 * Variabel yang tersedia:
 * - $page_title      : Judul halaman
 * - $page_subtitle   : Deskripsi halaman (opsional)
 * - $show_add_button : true/false - apakah tombol tambah ditampilkan
 * - $add_button_text : Teks tombol tambah (default: "Tambah Data")
 * - $add_button_icon : Icon tombol (default: "fa-solid fa-plus")
 * - $add_button_target : ID modal target (default: "#modalTambah")
 * - $add_button_class : Class tambahan untuk tombol (default: "btn-primary")
 * - $add_button_onclick : Fungsi onclick tambahan
 * 
 * Variabel profile (dari session):
 * - $userName   : Nama user (dari $_SESSION)
 * - $userRole   : Role user (dari $_SESSION)
 * - $userInitial: Inisial user
 */
?>

<div class="topbar">
    <div class="topbar-left">
        <div>
            <h2><?= htmlspecialchars($page_title ?? 'Dashboard') ?></h2>
            <?php if (isset($page_subtitle) && !empty($page_subtitle)): ?>
                <p><?= htmlspecialchars($page_subtitle) ?></p>
            <?php endif; ?>
        </div>
    </div>

    <div class="topbar-right">
        <!-- Tombol Notifikasi -->
        <button class="topbar-btn notif-btn" title="Notifikasi">
            <i class="fa-regular fa-bell"></i>
            <span class="notif-badge">3</span>
        </button>

        <!-- Profile Dropdown -->
        <div class="profile-dropdown">
            <button class="profile-btn" onclick="toggleDropdown()">
                <div class="profile-avatar">
                    <?= htmlspecialchars($userInitial ?? 'A') ?>
                </div>
                <div class="profile-info">
                    <h4><?= htmlspecialchars($userName ?? 'Administrator') ?></h4>
                    <span><?= htmlspecialchars($userRole ?? 'Admin DISPUSIPDA') ?></span>
                </div>
                <i class="fa-solid fa-chevron-down dropdown-arrow"></i>
            </button>

            <!-- Dropdown Menu -->
            <div class="dropdown-menu" id="profileDropdown">
                <div class="dropdown-header">
                    <div class="dropdown-avatar">
                        <?= htmlspecialchars($userInitial ?? 'A') ?>
                    </div>
                    <div>
                        <h4><?= htmlspecialchars($userName ?? 'Administrator') ?></h4>
                        <span><?= htmlspecialchars($userRole ?? 'Admin DISPUSIPDA') ?></span>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <a href="../profile.php" class="dropdown-item">
                    <i class="fa-regular fa-user"></i> Profil Saya
                </a>
                <a href="../pengaturan.php" class="dropdown-item">
                    <i class="fa-regular fa-gear"></i> Pengaturan
                </a>
                <div class="dropdown-divider"></div>
                <a href="../logout.php" class="dropdown-item logout-item">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar Sistem
                </a>
            </div>
        </div>

        <!-- Tombol Tambah (opsional) -->
        <?php if (isset($show_add_button) && $show_add_button === true): ?>
            <button type="button" class="btn-tambah-topbar <?= $add_button_class ?? 'btn-primary' ?>" 
                    onclick="<?= $add_button_onclick ?? "document.querySelector('" . ($add_button_target ?? '#modalTambah') . "').classList.add('is-open')" ?>">
                <i class="<?= $add_button_icon ?? 'fa-solid fa-plus' ?>"></i> 
                <?= htmlspecialchars($add_button_text ?? 'Tambah Data') ?>
            </button>
        <?php endif; ?>
    </div>
</div>

<style>
    /* ==========================
       TOPBAR STYLE
    ========================== */
    .topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        background: transparent;
        padding: 0;
        box-shadow: none;
        flex-wrap: wrap;
        gap: 16px;
    }

    .topbar-left h2 {
        color: #1e3a8a;
        font-size: 28px;
        font-weight: 700;
        margin: 0;
        padding: 0;
    }

    .topbar-left p {
        margin-top: 6px;
        color: #777;
        font-size: 14px;
        padding: 0;
    }

    .topbar-right {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    /* ===== TOMBOL NOTIFIKASI ===== */
    .topbar-btn {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        border: none;
        background: #fff;
        color: #555;
        font-size: 18px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        transition: 0.2s;
    }

    .topbar-btn:hover {
        background: #f8f9fc;
        transform: scale(1.05);
    }

    .topbar-btn .notif-badge {
        position: absolute;
        top: -4px;
        right: -4px;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #d64545;
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* ===== PROFILE DROPDOWN ===== */
    .profile-dropdown {
        position: relative;
        display: inline-block;
    }

    .profile-btn {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 6px 16px 6px 6px;
        border: none;
        border-radius: 10px;
        background: #fff;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        transition: 0.2s;
    }

    .profile-btn:hover {
        background: #f8f9fc;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.10);
    }

    .profile-btn .profile-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #1e40af;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        font-weight: 600;
        flex-shrink: 0;
    }

    .profile-btn .profile-info {
        text-align: left;
        line-height: 1.3;
    }

    .profile-btn .profile-info h4 {
        margin: 0;
        font-size: 14px;
        font-weight: 600;
        color: #1c1c2b;
    }

    .profile-btn .profile-info span {
        font-size: 12px;
        color: #8a8fa3;
    }

    .profile-btn .dropdown-arrow {
        font-size: 12px;
        color: #8a8fa3;
        transition: 0.3s;
        margin-left: 4px;
    }

    .profile-btn.active .dropdown-arrow {
        transform: rotate(180deg);
    }

    /* ===== DROPDOWN MENU ===== */
    .dropdown-menu {
        display: none;
        position: absolute;
        right: 0;
        top: calc(100% + 8px);
        min-width: 240px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        padding: 8px 0;
        z-index: 1000;
        animation: slideDown 0.2s ease;
    }

    .dropdown-menu.show {
        display: block;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .dropdown-header {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px 10px;
    }

    .dropdown-header .dropdown-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #1e40af;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: 600;
    }

    .dropdown-header h4 {
        margin: 0;
        font-size: 14px;
        font-weight: 600;
        color: #1c1c2b;
    }

    .dropdown-header span {
        font-size: 12px;
        color: #8a8fa3;
    }

    .dropdown-divider {
        height: 1px;
        background: #edeef3;
        margin: 6px 12px;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 16px;
        color: #1c1c2b;
        text-decoration: none;
        font-size: 14px;
        transition: 0.15s;
        cursor: pointer;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
    }

    .dropdown-item:hover {
        background: #f8f9fc;
    }

    .dropdown-item i {
        width: 18px;
        text-align: center;
        color: #8a8fa3;
        font-size: 15px;
    }

    .dropdown-item.logout-item {
        color: #d64545;
    }

    .dropdown-item.logout-item i {
        color: #d64545;
    }

    .dropdown-item.logout-item:hover {
        background: #fdecec;
    }

    /* ===== TOMBOL TAMBAH ===== */
    .btn-tambah-topbar {
        background: #059669;
        color: #fff;
        border: none;
        padding: 10px 22px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: 0.3s;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(5, 150, 105, 0.25);
        white-space: nowrap;
    }

    .btn-tambah-topbar:hover {
        background: #047857;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(5, 150, 105, 0.35);
    }

    .btn-tambah-topbar.btn-primary {
        background: #16215c;
        box-shadow: 0 4px 14px rgba(22, 33, 92, 0.25);
    }
    .btn-tambah-topbar.btn-primary:hover {
        background: #1c2a72;
    }

    /* ==========================
       RESPONSIVE
    ========================== */
    @media (max-width: 768px) {
        .topbar {
            flex-direction: column;
            align-items: stretch;
            gap: 16px;
            margin-bottom: 20px;
        }

        .topbar-left h2 {
            font-size: 22px;
        }

        .topbar-left p {
            font-size: 13px;
        }

        .topbar-right {
            flex-wrap: wrap;
            justify-content: flex-start;
        }

        .profile-btn .profile-info {
            display: none;
        }

        .profile-btn {
            padding: 6px 10px 6px 6px;
        }

        .btn-tambah-topbar {
            width: 100%;
            justify-content: center;
        }

        .dropdown-menu {
            right: -10px;
            min-width: 200px;
        }
    }

    @media (max-width: 480px) {
        .topbar-left h2 {
            font-size: 18px;
        }

        .topbar-btn {
            width: 36px;
            height: 36px;
            font-size: 15px;
        }
    }
</style>

<script>
    // Toggle dropdown profile
    function toggleDropdown() {
        const dropdown = document.getElementById('profileDropdown');
        const btn = document.querySelector('.profile-btn');
        dropdown.classList.toggle('show');
        btn.classList.toggle('active');
    }

    // Tutup dropdown saat klik di luar
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('profileDropdown');
        const btn = document.querySelector('.profile-btn');
        if (!event.target.closest('.profile-dropdown')) {
            dropdown.classList.remove('show');
            btn.classList.remove('active');
        }
    });

    // Tutup dropdown dengan tombol Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const dropdown = document.getElementById('profileDropdown');
            const btn = document.querySelector('.profile-btn');
            dropdown.classList.remove('show');
            btn.classList.remove('active');
        }
    });
</script>