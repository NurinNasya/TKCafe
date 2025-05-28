<?php
session_start();
require_once '../Model/cart.php';
require_once '../Model/menu.php';
require_once '../db.php';

$cartModel = new Cart($conn);
$menuModel = new Menu();
$items = $cartModel->getItems(session_id());
$total = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Cart - TK Cafe</title>
  <link rel="stylesheet" href="/TKCafe/public/css/style.css" />
  <link rel="stylesheet" href="/TKCafe/public/css/cart.css" />
</head>
<body>

<div class="cart-container">
  <h2>Your Cart</h2>
  
  <?php if (empty($items)): ?>
    <div class="empty-cart">
      <img src="/TKCafe/public/images/empty-cart.png" alt="Empty cart">
      <p>Your cart is empty</p>
      <a href="/TKCafe/Views/menu.php" class="btn">Browse Menu</a>
    </div>
  <?php else: ?>
    <div class="cart-items">
      <?php foreach ($items as $item): 
        $menuItem = $menuModel->getItemById($item['menu_id']);
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;
      ?>
        <div class="cart-item" data-id="<?= $item['id'] ?>">
          <img src="<?= htmlspecialchars($menuItem['image']) ?>" 
               alt="<?= htmlspecialchars($menuItem['name']) ?>" 
               class="cart-item-image">
          
          <div class="cart-item-details">
            <h3><?= htmlspecialchars($menuItem['name']) ?></h3>
            <div class="cart-item-meta">
              <span class="cart-item-price">RM <?= number_format($item['price'], 2) ?></span>
              <div class="cart-item-quantity">
                <span><?= $item['quantity'] ?> ×</span>
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
    
    <div class="cart-summary">
      <div class="summary-row">
        <span>Subtotal</span>
        <span>RM <?= number_format($total, 2) ?></span>
      </div>
      <div class="summary-row">
        <span>Service Charge (10%)</span>
        <span>RM <?= number_format($total * 0.10, 2) ?></span>
      </div>
      <div class="summary-row total">
        <span>Grand Total</span>
        <span>RM <?= number_format($total * 1.10, 2) ?></span>
      </div>
      
      <button class="checkout-btn">Proceed to Checkout</button>
      <a href="/TKCafe/Views/menu.php" class="continue-shopping-btn">Continue Shopping</a>
    </div>
  <?php endif; ?>
</div>

<script src="/TKCafe/public/js/cart.js"></script>
</body>
</html>