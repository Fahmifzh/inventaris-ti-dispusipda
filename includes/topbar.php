<?php
/**
 * TOPBAR - Reusable untuk semua halaman
 * 
 * Variabel yang tersedia:
 * - $page_title
 * - $page_subtitle
 * - $show_add_button
 * - $add_button_text
 * - $userName
 * - $userInitial
 */
?>

<link rel="stylesheet" href="topbar.css">

<div class="topbar">

    <div class="topbar-left">

        <button
            class="btn-hamburger"
            id="btnToggleSidebar"
            onclick="toggleSidebar()"
            aria-label="Toggle Navigation">

            <i class="fa-solid fa-bars"></i>

        </button>

        <div class="title-wrap">

            <h2><?= htmlspecialchars($page_title ?? 'Dashboard') ?></h2>

            <?php if (isset($page_subtitle) && !empty($page_subtitle)): ?>

                <p><?= htmlspecialchars($page_subtitle) ?></p>

            <?php endif; ?>

        </div>

    </div>

    <div class="topbar-right">

        <?php if (isset($show_add_button) && $show_add_button === true): ?>

            <button
                class="btn-add"
                onclick="document.querySelector('#modalTambah').classList.add('is-open')">

                <i class="fa-solid fa-plus"></i>

                <span><?= htmlspecialchars($add_button_text ?? 'Tambah Data') ?></span>

            </button>

        <?php endif; ?>

        <span class="divider"></span>

        <div class="profile-wrap">

            <button
                class="avatar"
                onclick="document.getElementById('dropdownLogout').classList.toggle('show')"
                aria-label="Profile Menu">

                <?= htmlspecialchars($userInitial ?? 'A') ?>

            </button>

            <div class="dropdown-logout" id="dropdownLogout">

                <a
                    href="/inventaris-ti-dispusipda/pages/profile/index.php"
                    class="dropdown-user">

                    <span class="avatar-small">

                        <?= htmlspecialchars($userInitial ?? 'A') ?>

                    </span>

                    <div class="user-info">

                        <strong>
                            <?= htmlspecialchars($userName ?? 'Administrator') ?>
                        </strong>

                        <small>
                            Administrator
                        </small>

                    </div>

                </a>

                <hr>

                <a
                    href="http://localhost:8080/inventaris-ti-dispusipda/logout.php"
                    class="btn-logout">

                    <i class="fa-solid fa-right-from-bracket"></i>

                    Logout

                </a>

            </div>

        </div>

    </div>

</div>

<script>

// Toggle Dropdown Logout
document.addEventListener('click', function(e) {

    const dropdown = document.getElementById('dropdownLogout');

    if (dropdown && !e.target.closest('.profile-wrap')) {

        dropdown.classList.remove('show');

    }

});

// Toggle Sidebar di Mobile
function toggleSidebar() {

    const sidebar = document.querySelector('.sidebar');

    if (sidebar) {

        sidebar.classList.toggle('active');

    }

}

// Tutup Sidebar Saat Klik Luar (HP)
document.addEventListener('click', function(event) {

    if (window.innerWidth <= 768) {

        const sidebar = document.querySelector('.sidebar');
        const hamburger = document.querySelector('.btn-hamburger');

        if (sidebar && sidebar.classList.contains('active')) {

            if (
                !sidebar.contains(event.target) &&
                !hamburger.contains(event.target)
            ) {

                sidebar.classList.remove('active');

            }

        }

    }

});

// Saat Resize ke Desktop
window.addEventListener('resize', function() {

    const sidebar = document.querySelector('.sidebar');

    if (sidebar && window.innerWidth > 768) {

        sidebar.classList.remove('active');

    }

});

</script>