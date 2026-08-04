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
        <!-- Tombol Tambah (opsional) -->
        <?php if (isset($show_add_button) && $show_add_button === true): ?>
            <button type="button" class="btn-tambah-topbar <?= $add_button_class ?? 'btn-primary' ?>" 
                    onclick="<?= $add_button_onclick ?? "document.querySelector('" . ($add_button_target ?? '#modalTambah') . "').classList.add('is-open')" ?>">
                <i class="<?= $add_button_icon ?? 'fa-solid fa-plus' ?>"></i> 
                <?= htmlspecialchars($add_button_text ?? 'Tambah Data') ?>
            </button>
        <?php endif; ?>

        <!-- Profile & Logout -->
        <div class="profile-logout">
            <div class="profile-info">
                <span class="profile-name"><?= htmlspecialchars($userName ?? 'Administrator') ?></span>
            </div>
            <a href="../logout.php" class="logout-link">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        </div>
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
        gap: 16px;
        flex-wrap: wrap;
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

    /* ===== PROFILE & LOGOUT ===== */
    .profile-logout {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 6px 16px 6px 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        transition: 0.2s;
    }

    .profile-logout:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.10);
    }

    .profile-info .profile-name {
        font-size: 14px;
        font-weight: 600;
        color: #1c1c2b;
    }

    .logout-link {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 8px;
        color: #d64545;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        transition: 0.2s;
        border: 1px solid transparent;
    }

    .logout-link:hover {
        background: #fdecec;
        border-color: #fdecec;
        color: #b33a3a;
    }

    .logout-link i {
        font-size: 14px;
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

        .btn-tambah-topbar {
            width: 100%;
            justify-content: center;
        }

        .profile-logout {
            width: 100%;
            justify-content: space-between;
            padding: 10px 16px;
        }
    }

    @media (max-width: 480px) {
        .topbar-left h2 {
            font-size: 18px;
        }

        .profile-logout {
            flex-wrap: wrap;
            gap: 8px;
            justify-content: center;
        }

        .logout-link {
            padding: 4px 10px;
            font-size: 12px;
        }
    }
</style>