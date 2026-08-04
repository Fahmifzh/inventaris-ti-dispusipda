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
 */
?>

<div class="topbar">
    <div>
        <h2><?= htmlspecialchars($page_title ?? 'Dashboard') ?></h2>
        <?php if (isset($page_subtitle) && !empty($page_subtitle)): ?>
            <p><?= htmlspecialchars($page_subtitle) ?></p>
        <?php endif; ?>
    </div>

    <?php if (isset($show_add_button) && $show_add_button === true): ?>
        <button type="button" class="btn-tambah-topbar <?= $add_button_class ?? 'btn-primary' ?>" 
                onclick="<?= $add_button_onclick ?? "document.querySelector('" . ($add_button_target ?? '#modalTambah') . "').classList.add('is-open')" ?>">
            <i class="<?= $add_button_icon ?? 'fa-solid fa-plus' ?>"></i> 
            <?= htmlspecialchars($add_button_text ?? 'Tambah Data') ?>
        </button>
    <?php endif; ?>
</div>

<style>
    /* ==========================
       TOPBAR - TANPA NOTIFIKASI & PROFILE
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

    .topbar h2 {
        color: #1e3a8a;
        font-size: 28px;
        font-weight: 700;
        margin: 0;
        padding: 0;
    }

    .topbar p {
        margin-top: 6px;
        color: #777;
        font-size: 14px;
        padding: 0;
    }

    /* ===== TOMBOL TOPBAR ===== */
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

    .btn-tambah-topbar i {
        font-size: 16px;
    }

    /* ===== VARIASI WARNA ===== */
    .btn-tambah-topbar.btn-primary {
        background: #16215c;
        box-shadow: 0 4px 14px rgba(22, 33, 92, 0.25);
    }
    .btn-tambah-topbar.btn-primary:hover {
        background: #1c2a72;
        box-shadow: 0 8px 20px rgba(22, 33, 92, 0.35);
    }

    .btn-tambah-topbar.btn-danger {
        background: #d64545;
        box-shadow: 0 4px 14px rgba(214, 69, 69, 0.25);
    }
    .btn-tambah-topbar.btn-danger:hover {
        background: #b33a3a;
        box-shadow: 0 8px 20px rgba(214, 69, 69, 0.35);
    }

    .btn-tambah-topbar.btn-warning {
        background: #d98b1f;
        box-shadow: 0 4px 14px rgba(217, 139, 31, 0.25);
    }
    .btn-tambah-topbar.btn-warning:hover {
        background: #b87518;
        box-shadow: 0 8px 20px rgba(217, 139, 31, 0.35);
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

        .topbar h2 {
            font-size: 22px;
        }

        .topbar p {
            font-size: 13px;
        }

        .btn-tambah-topbar {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .topbar h2 {
            font-size: 18px;
        }
    }
</style>