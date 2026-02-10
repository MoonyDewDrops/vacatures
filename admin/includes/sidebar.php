<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<aside class="admin-sidebar">
    <nav class="sidebar-nav">
        <a href="dashboard" class="nav-item <?php if($current_page == 'dashboard.php') echo 'active'; ?>">
            <span>Dashboard</span>
        </a>
        <a href="jobs" class="nav-item <?php if(strpos($current_page, 'job') !== false) echo 'active'; ?>">
            <span>Vacatures</span>
        </a>
        <a href="submissions" class="nav-item <?php if(strpos($current_page, 'submission') !== false) echo 'active'; ?>">
            <span>Inzendingen</span>
        </a>
        <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true): ?>
        <a href="users" class="nav-item <?php if(strpos($current_page, 'user') !== false) echo 'active'; ?>">
            <span>Gebruikers</span>
        </a>
        <?php endif; ?>
        <a href="/vacatures/" class="nav-item" target="_blank">
            <span>Website Bekijken</span>
        </a>
    </nav>
</aside>
