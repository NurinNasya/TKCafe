<aside class="sidebar">
    <div class="sidebar-header">
        <h2>TKCafe Admin</h2>
    </div>
    <nav class="sidebar-nav">
        <a href="dashboard.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">
            <span class="nav-icon">📊</span> Dashboard
        </a>
        <a href="tables.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'tables.php' ? 'active' : '' ?>">
            <span class="nav-icon">🪑</span> Tables
        </a>
        <a href="orders.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'orders.php' ? 'active' : '' ?>">
            <span class="nav-icon">📝</span> Orders
        </a>
    </nav>
</aside>