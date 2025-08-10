<?php
require_once '../Model/voucher.php';
$search = isset($_GET['search']) ? trim($_GET['search']) : null;
$vouchers = getAllVouchers();

// Pagination settings
$limit = 5; // Number of vouchers per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); // ensure page >= 1
$offset = ($page - 1) * $limit;

if ($search) {
    $totalVouchers = countSearchedVouchers($search); // 🔧 change
    $vouchers = searchVouchersByPage($search, $limit, $offset); // 🔧 change
} else {
    $totalVouchers = countVouchers(); // existing
    $vouchers = getVouchersByPage($limit, $offset); // existing
}

$totalPages = ceil($totalVouchers / $limit);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Vouchers</title>
  <link rel="stylesheet" href="/TKCafe/public/css/admin.css">
</head>
<body>
<div class="admin-container">
  <?php include 'partials/sidebar.php'; ?>


 <main class="main-content">
    <div class="section-header">
      <h2>Manage Vouchers</h2>

    </div>

    <div class="card">
      <h3>Voucher List</h3>
      <form method="GET" style="margin-bottom: 15px; display: flex; gap: 10px;">
  <input type="text" name="search" placeholder="Search voucher code..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" class="input-field">
  <button type="submit" class="btn btn-sm btn-primary">Search</button>
</form>


      <div style="text-align: right; margin-bottom: 15px;">
         <button class="btn btn-primary" id="openAddModal">+ Add Voucher</button>
      <div class="table-container">
    <table>
      <thead>
        <tr>
           <th>No.</th>
          <th>Code</th>
          <th>Description</th>
          <th>Discount</th>
          <th>Min Spend</th>
          <th>Valid Until</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php $counter = ($page - 1) * $limit + 1; ?>
        <?php foreach ($vouchers as $voucher): ?>
          <tr>
            <td>
             <tr>
             <td><?= $counter++ ?></td>
            <td><?= htmlspecialchars($voucher['code']) ?></td>
            <td><?= htmlspecialchars($voucher['description']) ?></td>
            <td>RM <?= number_format($voucher['discount_amount'], 2) ?></td>
            <td>RM <?= number_format($voucher['min_spend'], 2) ?></td>
            <?php
            $validDate = new DateTime($voucher['valid_until']);
            $today = new DateTime();
            $interval = $today->diff($validDate);
            $daysLeft = (int)$interval->format('%r%a');

            $validClass = $daysLeft <= 3 ? 'expiring-soon' : '';
          ?>
          <td class="<?= $validClass ?>">
            <?= $voucher['valid_until'] ?>
</td>
  <td>
  <div style="display: flex; gap: 5px;">
    <!-- Edit Button -->
    <button 
      class="btn btn-sm btn-warning edit-btn"
      data-id="<?= $voucher['id'] ?>"
      data-code="<?= htmlspecialchars($voucher['code']) ?>"
      data-description="<?= htmlspecialchars($voucher['description']) ?>"
      data-discount="<?= $voucher['discount_amount'] ?>"
      data-min="<?= $voucher['min_spend'] ?>"
      data-valid="<?= $voucher['valid_until'] ?>"
    >
      Edit
    </button>

    <!-- Delete Form -->
    <form method="POST" action="/TKCafe/Controller/voucherController.php"
          class="delete-form" onsubmit="return confirm('Delete this voucher?')">
      <input type="hidden" name="voucher_id" value="<?= $voucher['id'] ?>">
      <button type="submit" name="delete_voucher" class="btn btn-sm btn-danger">Delete</button>
    </form>
  </div>
</td>

              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
            </table> 
            <div class="pagination">
            <div class="pagination">
  <?php if ($page > 1): ?>
    <a href="?page=<?= $page - 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>">&laquo; Prev</a>
  <?php endif; ?>

  <?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <a href="?page=<?= $i ?><?= $search ? '&search=' . urlencode($search) : '' ?>" class="<?= ($i == $page) ? 'active' : '' ?>">
      <?= $i ?>
    </a>
  <?php endfor; ?>

  <?php if ($page < $totalPages): ?>
    <a href="?page=<?= $page + 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>">Next &raquo;</a>
  <?php endif; ?>
</div>

            <!-- Edit Voucher Modal -->
        <div id="editModal" style="display: none;">
          <div class="edit-modal-content">
            <span class="close">&times;</span>
            <h2>Edit Voucher</h2>
            <form method="POST" action="/TKCafe/Controller/voucherController.php">
              <input type="hidden" name="edit_id" id="edit-id">
              <input type="text" name="edit_code" id="edit-code" required>
              <input type="text" name="edit_description" id="edit-description">
              <input type="number" name="edit_discount" id="edit-discount" step="0.01" required>
              <input type="number" name="edit_min_spend" id="edit-min" step="0.01" required>
              <input type="date" name="edit_valid_until" id="edit-valid" required>
              <button type="submit" name="update_voucher" class="btn btn-success">Save Changes</button>
              <button type="button" class="btn btn-secondary" onclick="closeEditForm()">Cancel</button>
            </form>
          </div>
        </div>

        
        <!-- Add Voucher Modal -->
        <div id="addModal" class="modal" style="display: none;">
          <div class="modal-content">
            <span class="close" id="closeAddModal">&times;</span>
            <h2>Add New Voucher</h2>
            <form method="POST" action="/TKCafe/Controller/voucherController.php">
              <input type="text" name="code" placeholder="Voucher Code (e.g. WELCOME10)" required>
              <input type="text" name="description" placeholder="Description">
              <input type="number" name="discount" step="0.01" placeholder="Discount (e.g. 10.00)" required>
              <input type="number" name="min_spend" step="0.01" placeholder="Min Spend (e.g. 20.00)" required>
              <input type="date" name="valid_until" required>
              <button type="submit" name="add_voucher" class="btn btn-success">Add Voucher</button>
            </form>
          </div>
        </div>

              <script src="/TKCafe/public/js/voucher.js"></script>
        </body>
        </html>
