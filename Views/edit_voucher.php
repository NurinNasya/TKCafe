<?php
require_once '../Model/voucher.php';

// Get voucher ID from query string
if (!isset($_GET['id'])) {
    header('Location: manage_vouchers.php');
    exit;
}

$voucherId = intval($_GET['id']);
$voucher = getVoucherById($voucherId);

if (!$voucher) {
    echo "Voucher not found.";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Voucher</title>
  <link rel="stylesheet" href="/TKCafe/public/css/admin.css">
</head>
<body>
<div class="admin-container">
  <?php include 'partials/sidebar.php'; ?>
  <main class="main-content">
    <h1>Edit Voucher</h1>

    <form method="POST" action="/TKCafe/Controller/voucherController.php">
      <input type="hidden" name="voucher_id" value="<?= $voucher['id'] ?>">
      <label>Voucher Code</label>
      <input type="text" name="code" value="<?= htmlspecialchars($voucher['code']) ?>" required>

      <label>Description</label>
      <input type="text" name="description" value="<?= htmlspecialchars($voucher['description']) ?>">

      <label>Discount Amount (RM)</label>
      <input type="number" step="0.01" name="discount" value="<?= $voucher['discount_amount'] ?>" required>

      <label>Minimum Spend (RM)</label>
      <input type="number" step="0.01" name="min_spend" value="<?= $voucher['min_spend'] ?>" required>

      <label>Valid Until</label>
      <input type="date" name="valid_until" value="<?= $voucher['valid_until'] ?>" required>

      <button type="submit" name="update_voucher" class="btn btn-success">Update Voucher</button>
      <a href="manage_vouchers.php" class="btn btn-secondary">Cancel</a>
    </form>
  </main>
</div>
</body>
</html>
