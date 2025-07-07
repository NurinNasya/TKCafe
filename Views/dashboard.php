<?php
require_once '../db.php';
require_once '../Model/dashboardstats.php';

session_start();

$conn = getConnection();

// Only allow access if logged in as admin
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$totalSales = getTotalSales($conn);
$totalOrders = getTotalOrders($conn);
$todaysOrders = getTodaysOrders($conn);
 // Rename here to match usage below

// 🟢 For sales chart
$salesData = getSalesLast7Days($conn);
$chartLabels = array_column($salesData, 'sale_date');
$chartValues = array_column($salesData, 'total_sales');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="/TKCafe/public/css/admin.css">
</head>
<body>
  <div class="admin-container">
    <!-- Sidebar Navigation -->
     <?php require 'partials/sidebar.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
      <header class="top-header">
        <h1>Dashboard Overview</h1>
        <div class="header-actions">
          <button class="btn btn-primary">Generate Report</button>
          <div class="user-avatar">AD</div>
        </div>
      </header>

      <!-- Stats Cards -->
       <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-icon primary">💰</div>
          <h3>Total Sales</h3>
          <p class="stat-value">RM <?= number_format($totalSales, 2) ?></p>
          <p class="stat-change">+RM <?= number_format($totalSales - 150, 2) ?> today</p>
        </div>

        <div class="stat-card">
          <div class="stat-icon success">🛒</div>
          <h3>Total Orders</h3>
          <p class="stat-value"><?= $totalOrders ?></p>
          <p class="stat-change">+<?= $todaysOrders ?> today</p>
        </div>

        <div class="stat-card">
          <div class="stat-icon info">📅</div>
          <h3>Today's Orders</h3>
          <p class="stat-value"><?= $todaysOrders ?></p>
          <p class="stat-change">Updated just now</p>
        </div>
      </div>
  <!-- 📈 Sales Chart -->
      <section class="data-section">
        <div class="section-header">
          <h2>Sales - Last 7 Days</h2>
        </div>
        <canvas id="salesChart" style="max-height: 400px; margin-bottom: 2rem;"></canvas>
      </section>

    </main>
  </div>
   <!-- ✅ Chart.js + Data Passing + Custom JS -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    window.chartLabels = <?= json_encode($chartLabels) ?>;
    window.chartValues = <?= json_encode($chartValues) ?>;
  </script>
  <script src="/TKCafe/public/js/salesChart.js"></script>
</body>
</html>