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
          <div class="stat-icon primary">📝</div>
          <h3>Active Orders</h3>
          <p class="stat-value">24</p>
          <p class="stat-change">+5 from yesterday</p>
        </div>
        <div class="stat-card">
          <div class="stat-icon warning">🪑</div>
          <h3>Occupied Tables</h3>
          <p class="stat-value">8/20</p>
          <p class="stat-change">40% capacity</p>
        </div>
        <div class="stat-card">
          <div class="stat-icon danger">⚠️</div>
          <h3>Pending Tasks</h3>
          <p class="stat-value">3</p>
          <p class="stat-change">2 urgent</p>
        </div>
      </div>

      <!-- Recent Orders Table -->
      <section class="data-section">
        <div class="section-header">
          <h2>Recent Orders</h2>
          <button class="btn btn-outline">View All</button>
        </div>
        
        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Table</th>
                <th>Items</th>
                <th>Amount</th>
                <th>Status</th>
                <th class="text-right">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>#1025</td>
                <td>Table 3</td>
                <td>2x Burger, 1x Fries</td>
                <td>$24.50</td>
                <td><span class="badge badge-warning">Preparing</span></td>
                <td class="text-right">
                  <button class="btn btn-sm btn-primary">View</button>
                </td>
              </tr>
              <tr>
                <td>#1024</td>
                <td>Table 7</td>
                <td>1x Pizza, 2x Soda</td>
                <td>$18.00</td>
                <td><span class="badge badge-success">Completed</span></td>
                <td class="text-right">
                  <button class="btn btn-sm btn-primary">View</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>
    </main>
  </div>
</body>
</html>