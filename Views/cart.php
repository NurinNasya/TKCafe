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
          <?php foreach ($items as $item): 
          $menuItem = $menuModel->getItemById($item['menu_id']);
          $subtotal = $item['price'] * $item['quantity'];
          $total += $subtotal;
          
          // Parse customizations
          $customizations = !empty($item['customizations']) 
            ? json_decode($item['customizations'], true) 
            : null;
        ?>
          <div class="cart-item" data-id="<?= $item['id'] ?>">
            <img src="<?= htmlspecialchars($menuItem['image']) ?>" 
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
        <span>Grand Total =</span>
        <span>RM <?= number_format($total * 1.10, 2) ?></span>
      </div>
      
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