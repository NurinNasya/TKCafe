<?php
session_start();
require_once '../Model/cart.php';
require_once '../Model/menu.php';
require_once '../db.php';

$conn = getConnection(); // ✅ This is now necessary

// $menuItem = getMenuItemById($conn, $item['menu_id']); // ✅ NEW
$session_id = session_id(); 
$items = getItems($conn, $session_id); 
// $items = $cartModel->getItems(session_id());
$total = 0;

  // First, calculate the subtotal before applying voucher
foreach ($items as $item) {
    $subtotal = $item['price'] * $item['quantity'];
    $total += $subtotal;
}

// === Voucher Handling ===
$voucherAmount = 0;
$voucherCode = '';
$error = '';

// ✅ Auto-load existing voucher from session (if previously applied)
if (isset($_SESSION['voucher'])) {
    $voucherCode = $_SESSION['voucher']['code'];
    $voucherAmount = $_SESSION['voucher']['amount'];
}

if (isset($_POST['apply_voucher'])) {
    $voucherCode = strtoupper(trim($_POST['voucher_code']));
    $query = "SELECT * FROM vouchers WHERE code = '$voucherCode' AND valid_until >= CURDATE()";
    $voucherResult = mysqli_query($conn, $query);

    if ($voucherRow = mysqli_fetch_assoc($voucherResult)) {
        if ($total >= $voucherRow['min_spend']) {
            $voucherAmount = $voucherRow['discount_amount'];

            // ✅ FIXED: Save applied voucher to session so it can be used in orderController
            $_SESSION['voucher'] = [
                'code' => $voucherCode,
                'amount' => $voucherAmount
            ];
        } else {
            $error = "Spend RM " . number_format($voucherRow['min_spend'], 2) . " to use this voucher.";
            unset($_SESSION['voucher']); // Clear session if not valid
        }
    } else {
        $error = "Invalid or expired voucher.";
        unset($_SESSION['voucher']); // Clear session if invalid
    }
}

// // === Voucher Handling ===
// $voucherAmount = 0;
// $voucherCode = '';
// $error = '';

// if (isset($_POST['apply_voucher'])) {
//     $voucherCode = strtoupper(trim($_POST['voucher_code']));
//     $query = "SELECT * FROM vouchers WHERE code = '$voucherCode' AND valid_until >= CURDATE()";
//     $voucherResult = mysqli_query($conn, $query);

//     if ($voucherRow = mysqli_fetch_assoc($voucherResult)) {
//         if ($total >= $voucherRow['min_spend']) {
//             $voucherAmount = $voucherRow['discount_amount'];
//         } else {
//             $error = "Spend RM " . number_format($voucherRow['min_spend'], 2) . " to use this voucher.";
//         }
//     } else {
//         $error = "Invalid or expired voucher.";
//     }
// }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Your Cart - TK Cafe</title>
  <link rel="stylesheet" href="/TKCafe/public/css/style.css" />
  <link rel="stylesheet" href="/TKCafe/public/css/cart.css" />
</head>
<body>

<div class="cart-container">

<div class="cart-header">
  <!--<a href="javascript:history.back()" class="back-button">&lt;</a>-->
  <a href="/TKCafe/Views/menu.php" class="back-button">&lt;</a>
  <h2 class="cart-title">CART</h2>
</div>
  <?php if (empty($items)): ?>
    <div class="empty-cart">
      <p>Your cart is empty</p>
      <a href="/TKCafe/Views/menu.php" class="btn">Browse Menu</a>
    </div>

  <?php else: ?>
    <div class="cart-items">

          <?php 
          foreach ($items as $item): 
        $menuItem = getMenuItemById($conn, $item['menu_id']); // ✅ Move here
        $subtotal = $item['price'] * $item['quantity'];
        
        

        // Parse customizations
        $customizations = !empty($item['customizations']) 
        ? json_decode($item['customizations'], true) 
        : null;
          /*foreach ($items as $item): 
          $menuItem = $menuModel->getItemById($item['menu_id']);
          $subtotal = $item['price'] * $item['quantity'];
          $total += $subtotal;
          
          // Parse customizations
          $customizations = !empty($item['customizations']) 
            ? json_decode($item['customizations'], true) 
            : null;*/
        ?>
          <div class="cart-item" data-id="<?= $item['id'] ?>">
          <img src="/TKCafe/uploads/<?= htmlspecialchars($menuItem['image']) ?>" 
                alt="<?= htmlspecialchars($menuItem['name']) ?>"
                 class="cart-item-image">
            
            <div class="cart-item-details">
              <h3><?= htmlspecialchars($menuItem['name']) ?></h3>
              
              <?php if ($customizations && isset($customizations['drink'])): ?>
                <div class="customization-display">
                  <p>Drink: <?= htmlspecialchars(ucfirst(str_replace('-', ' ', $customizations['drink']))) ?></p>
                </div>
              <?php endif; ?>

              <!--for remarks here-->
              <?php if (!empty($item['remarks'])): ?>
                <div class="remarks-display">
                    <p><strong>Note:</strong> <?= htmlspecialchars($item['remarks']) ?></p>
                </div>
            <?php endif; ?>    
    
              <div class="cart-item-meta">
                <span class="cart-item-price">RM <?= number_format($item['price'], 2) ?></span>
                <div class="cart-item-quantity">
                  <button class="quantity-btn minus" data-id="<?= $item['id'] ?>">-</button>
                  <span class="quantity-value"><?= $item['quantity'] ?></span>
                  <button class="quantity-btn plus" data-id="<?= $item['id'] ?>">+</button>
                </div>
                <span class="cart-item-subtotal">RM <?= number_format($subtotal, 2) ?></span>
              </div>
            </div>
            
            <button class="remove-item-btn" data-id="<?= $item['id'] ?>">
              <svg width="20" height="20" viewBox="0 0 24 24">
                <path d="M19 13H5v-2h14v2z"/>
              </svg>
            </button>
          </div>
        <?php endforeach; ?>
    </div>
    
      <div class="cutlery-toggle">
      <label for="cutlerySwitch">Cutlery</label>
      <label class="switch">
        <input type="checkbox" id="cutlerySwitch">
        <span class="slider round"></span>
      </label>
    </div>

    <div class="cart-summary">
      <div class="summary-row">
        <span>Subtotal</span>
        <span>RM <?= number_format($total, 2) ?></span>
      </div>

     <!-- Voucher Form -->
  <form method="POST" class="voucher-form">
  <input type="text" name="voucher_code" placeholder="Enter voucher code" value="<?= htmlspecialchars($voucherCode) ?>">
  <button type="submit" name="apply_voucher">Apply</button>
  <?php if (!empty($error)): ?>
    <p class="error"><?= $error ?></p>
  <?php endif; ?>
   </form>


      <div class="summary-row">
        <span>Service Charge (10%)</span>
       <span>RM <?= number_format(($total * 1.10) - $voucherAmount, 2) ?></span>

      </div>
      <div class="summary-row total">
        <span>Grand Total =</span>
       <span>RM <?= number_format(($total * 1.10) - $voucherAmount, 2) ?></span>
      </div>

   <!-- Voucher Discount -->
  <?php if ($voucherAmount > 0): ?>
  <div class="summary-row">
    <span>Voucher Discount</span>
    <span>- RM <?= number_format($voucherAmount, 2) ?></span>
   </div>
  <?php endif; ?>

  <button class="checkout-btn">PLACE ORDER</button>
     
    </div>
  <?php endif; ?>
</div>

 <div class="delete-modal" id="deleteModal">
      <div class="modal-content">
        <p>Do you want to delete this item?</p>
        <div class="modal-buttons">
          <button class="modal-btn confirm-btn">Yes</button>
          <button class="modal-btn cancel-btn">No</button>
        </div>
      </div>
    </div>

<script src="/TKCafe/public/js/cart.js"></script>
</body>
</html>