<?php
require_once '../Model/voucher.php';
$vouchers = getAllVouchers();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Vouchers</title>
  <link rel="stylesheet" href="/TKCafe/public/css/admin.css">
</head>
<body>
<div class="admin-container">
  <?php include 'partials/sidebar.php'; ?>
  <main class="main-content">
    <h1>Manage Vouchers</h1>

    <table>
       <!-- Add Voucher Button -->
<button id="openAddModal" class="btn btn-primary add-btn-top">+ Add Voucher</button>
      <thead>
        <tr>
          <th>Code</th>
          <th>Description</th>
          <th>Discount</th>
          <th>Min Spend</th>
          <th>Valid Until</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($vouchers as $voucher): ?>
          <tr>
            <td><?= htmlspecialchars($voucher['code']) ?></td>
            <td><?= htmlspecialchars($voucher['description']) ?></td>
            <td>RM <?= number_format($voucher['discount_amount'], 2) ?></td>
            <td>RM <?= number_format($voucher['min_spend'], 2) ?></td>
            <td><?= $voucher['valid_until'] ?></td>
            <td>

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

                </td>

              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    
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
