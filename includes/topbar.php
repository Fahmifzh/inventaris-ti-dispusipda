<?php
/**
 * TOPBAR - Reusable untuk semua halaman
 * Gunakan: include 'includes/topbar.php';
 * 
 * Variabel yang tersedia:
 * - $page_title   : Judul halaman (contoh: "Dashboard")
 * - $page_subtitle: Deskripsi halaman (opsional)
 * - $page_icon    : Icon halaman (opsional, default: "fa-solid fa-gauge-high")
 */
?>

<div class="topbar">
    <div class="topbar-left">
        <div class="topbar-icon">
            <i class="<?= $page_icon ?? 'fa-solid fa-gauge-high' ?>"></i>
        </div>
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

        <!-- Tombol Bantuan -->
        <button class="topbar-btn" title="Bantuan">
            <i class="fa-regular fa-circle-question"></i>
        </button>

        <!-- Profile -->
        <div class="topbar-profile">
            <div class="profile-avatar">
                <span><?= $userInitial ?? 'A' ?></span>
            </div>
            <div class="profile-info">
                <h4><?= htmlspecialchars($userName ?? 'Administrator') ?></h4>
                <span><?= htmlspecialchars($userRole ?? 'Admin DISPUSIPDA') ?></span>
            </div>
            <button class="profile-dropdown-btn">
                <i class="fa-solid fa-chevron-down"></i>
            </button>
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
        padding: 20px 30px;
        background: #ffffff;
        border-radius: 14px;
        box-shadow: 0 1px 3px rgba(20, 25, 60, 0.05);
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .topbar-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .topbar-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: #eef0fb;
        color: #2b3f9e;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .topbar-left h2 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
        color: #1c1c2b;
        line-height: 1.3;
    }

    .topbar-left p {
        margin: 2px 0 0;
        font-size: 13px;
        color: #8a8fa3;
    }

    /* ==========================
       TOPBAR RIGHT
    ========================== */
    .topbar-right {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .topbar-btn {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        border: none;
        background: #f8f9fc;
        color: #5a5f7a;
        font-size: 18px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        transition: 0.2s;
    }

    .topbar-btn:hover {
        background: #eef0fb;
        color: #2b3f9e;
    }

    .notif-badge {
        position: absolute;
        top: -2px;
        right: -2px;
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

    /* ==========================
       PROFILE
    ========================== */
    .topbar-profile {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 4px 12px 4px 4px;
        border-radius: 10px;
        background: #f8f9fc;
        cursor: pointer;
        transition: 0.2s;
        border: 1px solid transparent;
    }

    .topbar-profile:hover {
        background: #eef0fb;
        border-color: #e0e3ed;
    }

    .profile-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #2b3f9e;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        font-weight: 600;
        flex-shrink: 0;
    }

    .profile-info h4 {
        margin: 0;
        font-size: 13.5px;
        font-weight: 600;
        color: #1c1c2b;
        line-height: 1.2;
    }

    .profile-info span {
        font-size: 11.5px;
        color: #8a8fa3;
    }

    .profile-dropdown-btn {
        background: none;
        border: none;
        color: #8a8fa3;
        font-size: 12px;
        cursor: pointer;
        padding: 4px;
    }

    .profile-dropdown-btn:hover {
        color: #2b3f9e;
    }

    /* ==========================
       RESPONSIVE
    ========================== */
    @media (max-width: 768px) {
        .topbar {
            padding: 16px 18px;
            flex-direction: column;
            align-items: stretch;
        }

        .topbar-left {
            gap: 12px;
        }

        .topbar-icon {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }

        .topbar-left h2 {
            font-size: 17px;
        }

        .topbar-right {
            justify-content: flex-end;
            flex-wrap: wrap;
        }

        .profile-info {
            display: none;
        }

        .topbar-profile {
            padding: 4px 6px 4px 4px;
        }
    }

    @media (max-width: 480px) {
        .topbar {
            padding: 14px;
        }

        .topbar-left h2 {
            font-size: 15px;
        }

        .topbar-btn {
            width: 34px;
            height: 34px;
            font-size: 15px;
        }

        .profile-avatar {
            width: 32px;
            height: 32px;
            font-size: 12px;
        }
    }
</style>