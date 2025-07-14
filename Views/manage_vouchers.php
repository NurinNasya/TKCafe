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

    <form method="POST" action="/TKCafe/Controller/voucherController.php">
      <h3>Add New Voucher</h3>
      <input type="text" name="code" placeholder="Voucher Code (e.g. WELCOME10)" required>
      <input type="text" name="description" placeholder="Description">
      <input type="number" name="discount" step="0.01" placeholder="Discount (e.g. 10.00)" required>
      <input type="number" name="min_spend" step="0.01" placeholder="Min Spend (e.g. 20.00)" required>
      <input type="date" name="valid_until" required>
      <button type="submit" name="add_voucher" class="btn btn-success">Add Voucher</button>
    </form>

    <h3>Existing Vouchers</h3>
    <table>
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
              <form method="POST" action="/TKCafe/Controller/voucherController.php" onsubmit="return confirm('Delete this voucher?')">
                <input type="hidden" name="voucher_id" value="<?= $voucher['id'] ?>">
                <button type="submit" name="delete_voucher" class="btn btn-sm btn-danger">Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </main>
</div>
</body>
</html>
