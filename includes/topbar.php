<?php

$userName = $_SESSION['nama'] ?? 'Administrator';
$userInitial = strtoupper(substr($userName,0,1));

?>

<header class="topbar">

    <div class="topbar-left">

        <button class="btn-toggle-sidebar" onclick="toggleSidebar()">

            <i class="fa-solid fa-bars"></i>

        </button>

        <div class="page-header-text">

            <h2><?= htmlspecialchars($page_title ?? 'Dashboard'); ?></h2>

            <?php if(!empty($page_subtitle)): ?>

                <p><?= htmlspecialchars($page_subtitle); ?></p>

            <?php endif; ?>

        </div>

    </div>

    <div class="topbar-right">

        <?php if(isset($show_add_button) && $show_add_button): ?>

            <button class="btn-add" onclick="triggerAddModal()">

                <i class="fa-solid fa-plus"></i>

                <span class="btn-text">

                    <?= htmlspecialchars($add_button_text ?? 'Tambah Data'); ?>

                </span>

            </button>

        <?php endif; ?>

        <div class="profile-wrap">

            <button class="avatar" onclick="toggleDropdownLogout(event)">

                <?= $userInitial; ?>

            </button>

            <div class="dropdown-logout" id="dropdownLogout">

                <div class="dropdown-user">

                    <span class="avatar-small">

                        <?= $userInitial; ?>

                    </span>

                    <div class="user-info">

                        <strong>

                            <?= htmlspecialchars($userName); ?>

                        </strong>

                        <small>

                            Administrator

                        </small>

                    </div>

                </div>

                <hr>

                <a href="/inventaris-ti-dispusipda/logout.php" class="btn-logout">

                    <i class="fa-solid fa-right-from-bracket"></i>

                    Logout

                </a>

            </div>

        </div>

    </div>

</header>

<script>

function toggleSidebar(){

    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    if(sidebar){
        sidebar.classList.toggle('active');
    }

    if(overlay){
        overlay.classList.toggle('active');
    }

}

function toggleDropdownLogout(event){

    event.stopPropagation();

    document
    .getElementById('dropdownLogout')
    .classList
    .toggle('show');

}

document.addEventListener('click',function(){

    const dropdown =
    document.getElementById('dropdownLogout');

    if(dropdown){
        dropdown.classList.remove('show');
    }

});

function triggerAddModal(){

    const modal =
    document.getElementById('modalTambah');

    if(modal){
        modal.classList.add('show');
    }

}

</script>