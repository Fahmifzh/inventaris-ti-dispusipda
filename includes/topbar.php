<?php
/**
 * TOPBAR - Reusable untuk semua halaman
 * 
 * Variabel yang tersedia:
 * - $page_title      : Judul halaman
 * - $page_subtitle   : Deskripsi halaman (opsional)
 * - $show_add_button : true/false - apakah tombol tambah ditampilkan
 * - $add_button_text : Teks tombol tambah
 * - $userName        : Nama user (dari $_SESSION)
 * - $userInitial     : Inisial user (huruf pertama)
 */
?>

<div class="topbar">
    <div>
        <h2><?= htmlspecialchars($page_title ?? 'Dashboard') ?></h2>
        <?php if (isset($page_subtitle) && !empty($page_subtitle)): ?>
            <p><?= htmlspecialchars($page_subtitle) ?></p>
        <?php endif; ?>
    </div>

    <div class="topbar-right">
        <?php if (isset($show_add_button) && $show_add_button === true): ?>
            <button class="btn-add" onclick="document.querySelector('#modalTambah').classList.add('is-open')">
                <i class="fa-solid fa-plus"></i> <?= htmlspecialchars($add_button_text ?? 'Tambah Data') ?>
            </button>
        <?php endif; ?>

        <!-- GARIS PEMISAH -->
        <span class="divider"></span>

        <div class="profile-wrap">
            <button class="avatar" onclick="document.getElementById('dropdownLogout').classList.toggle('show')">
                <?= htmlspecialchars($userInitial ?? 'A') ?>
            </button>
            <div class="dropdown-logout" id="dropdownLogout">
                <div class="dropdown-user">
                    <span class="avatar-small"><?= htmlspecialchars($userInitial ?? 'A') ?></span>
                    <div>
                        <strong><?= htmlspecialchars($userName ?? 'Administrator') ?></strong>
                        <small>Administrator</small>
                    </div>
                </div>
                <hr>
                <a href="/inventaris-ti-dispusipda/logout.php" class="btn-logout">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 16px;
}
.topbar h2 {
    color: #1e3a8a;
    font-size: 28px;
    font-weight: 700;
    margin: 0;
}
.topbar p {
    color: #777;
    font-size: 14px;
    margin: 4px 0 0;
}
.topbar-right {
    display: flex;
    align-items: center;
    gap: 16px;
}

/* Tombol Tambah */
.btn-add {
    background: #059669;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: 0.2s;
}
.btn-add:hover {
    background: #047857;
}

/* ===== GARIS PEMISAH ===== */
.divider {
    width: 1px;
    height: 32px;
    background: #d0d5e0;
    display: inline-block;
    flex-shrink: 0;
    opacity: 0.6;
}

/* Avatar */
.avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    border: none;
    background: #1e40af;
    color: #fff;
    font-weight: 600;
    font-size: 18px;
    cursor: pointer;
    text-transform: uppercase;
    transition: 0.2s;
}
.avatar:hover {
    transform: scale(1.05);
}

/* Dropdown Logout */
.profile-wrap {
    position: relative;
}
.dropdown-logout {
    display: none;
    position: absolute;
    right: 0;
    top: calc(100% + 8px);
    min-width: 200px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    padding: 12px 0;
    z-index: 999;
}
.dropdown-logout.show {
    display: block;
}
.dropdown-user {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 0 16px 8px;
}
.avatar-small {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #1e40af;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 14px;
    text-transform: uppercase;
}
.dropdown-user strong {
    display: block;
    font-size: 14px;
    color: #1c1c2b;
}
.dropdown-user small {
    font-size: 12px;
    color: #8a8fa3;
}
.dropdown-logout hr {
    border: none;
    border-top: 1px solid #edeef3;
    margin: 6px 12px;
}
.btn-logout {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 16px;
    color: #d64545;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    border-radius: 0;
    transition: 0.15s;
}
.btn-logout:hover {
    background: #fdecec;
}

/* Responsive */
@media (max-width: 768px) {
    .topbar {
        flex-direction: column;
        align-items: stretch;
    }
    .btn-add {
        width: 100%;
        justify-content: center;
    }
    .topbar-right {
        flex-wrap: wrap;
        justify-content: flex-start;
    }
    .divider {
        height: 28px;
    }
}
</style>

<script>
document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('dropdownLogout');
    if (!e.target.closest('.profile-wrap')) {
        dropdown.classList.remove('show');
    }
});
</script>