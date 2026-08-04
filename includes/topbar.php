<?php
/**
 * TOPBAR - Reusable untuk semua halaman
 * Gunakan: include 'includes/topbar.php';
 * 
 * Variabel yang tersedia:
 * - $page_title   : Judul halaman
 * - $page_subtitle: Deskripsi halaman (opsional)
 * - $page_icon    : Icon halaman (opsional)
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
        <div class="notification">
            <i class="fa-regular fa-bell"></i>
        </div>
        <div class="profile">
            <div class="profile-avatar">
                <?= $userInitial ?? 'A' ?>
            </div>
            <div>
                <h4><?= htmlspecialchars($userName ?? 'Administrator') ?></h4>
                <span><?= htmlspecialchars($userRole ?? 'Administrator') ?></span>
            </div>
        </div>
    </div>
</div>

<style>
    /* ==========================
       TOPBAR - SAMA PERSIS DENGAN DASHBOARD
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
        gap: 20px;
    }

    /* ===== NOTIFICATION ===== */
    .notification {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 5px 18px rgba(0, 0, 0, 0.08);
        cursor: pointer;
        transition: 0.2s;
        position: relative;
    }

    .notification:hover {
        background: #f8f9fc;
        transform: scale(1.05);
    }

    .notification i {
        color: #555;
        font-size: 20px;
    }

    .notification .badge {
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

    /* ===== PROFILE ===== */
    .profile {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .profile-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #1e40af;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: 600;
        flex-shrink: 0;
    }

    .profile h4 {
        color: #333;
        font-size: 15px;
        margin: 0;
        padding: 0;
    }

    .profile span {
        color: #888;
        font-size: 13px;
    }

    /* ==========================
       RESPONSIVE
    ========================== */
    @media (max-width: 768px) {
        .topbar {
            flex-direction: column;
            align-items: flex-start;
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
            width: 100%;
            justify-content: flex-start;
        }

        .profile h4,
        .profile span {
            display: none;
        }
    }

    @media (max-width: 480px) {
        .topbar-left h2 {
            font-size: 18px;
        }

        .notification {
            width: 38px;
            height: 38px;
        }

        .profile-avatar {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }
    }
</style>