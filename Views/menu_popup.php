
<?php 
session_start();
if (!isset($item)) {
    echo "No item data.";
    exit;
}
  $categoriesWithRemarks = [
  'masakan-ala',
  'masakan-side',
  'lokcing',
  'western',
  'air-balang',
  'soft-drinks',
  'hot-drinks'
];
?>

<link rel="stylesheet" href="/TKCafe/public/css/style.css" />

<div class="menu-details-container">
   <button class="close-popup-btn" onclick="closeMenuPopup()">×</button>

    <!-- Add hidden order_id here -->
     <input type="hidden" id="current_order_id" value="<?= htmlspecialchars($_GET['order_id'] ?? ($_SESSION['current_order']['id'] ?? '')) ?>">

   
  <h1 class="menu-title"><?= htmlspecialchars($item['name']) ?></h1>

 <img src="/TKCafe/uploads/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="menu-image" />


  <p class="menu-description"><?= htmlspecialchars($item['description']) ?></p>

  <?php 
  // Check if this is a combo set (either standard or signature)
  $isCombo = strpos($item['category'], 'set-') === 0;
  ?>

  <?php if ($isCombo): ?>
    <!-- COMBO CUSTOMIZATION SECTION -->
    <div class="combo-customization">
      <!-- Drink Selection Section -->
      <div class="custom-section">
        <h3>Choose drink</h3>
        
        <div class="option">
          <input type="radio" id="coke" name="drink" value="Coca Cola" required>
          <label for="coke">Coca Cola</label>
        </div>
        
        <div class="option">
          <input type="radio" id="sprite" name="drink" value="Sprite">
          <label for="sprite">Sprite</label>
        </div>
        
        <div class="option">
          <input type="radio" id="fn_orange" name="drink" value="F&N Orange">
          <label for="fn_orange">F&N Orange</label>
        </div>
        
        <div class="option">
          <input type="radio" id="fn_zapple" name="drink" value="F&N Zapple">
          <label for="fn_zapple">F&N Zapple</label>
        </div>
        
        <div class="option">
          <input type="radio" id="fn_strawberry" name="drink" value="F&N Strawberry">
          <label for="fn_strawberry">F&N Strawberry</label>
        </div>
       
        <div class="option">
          <input type="radio" id="fn_soda" name="drink" value="F&N Soda">
          <label for="fn_soda">F&N Soda</label>
        </div>
      </div>
    </div>
  <?php endif; ?>

<p class="menu-price">
  <strong>Price:</strong> <?= 'RM' . number_format((float)str_replace('RM', '', $item['price']), 2) ?>
</p>

<?php if (in_array($item['category'], $categoriesWithRemarks)): ?>
<!-- Stylish Remarks Section -->
  <div class="remarks-section">
    <label for="remarks" class="remarks-label">
      <span class="remarks-icon">💬</span> Remark
    </label>
    <textarea id="remarks" name="remarks" class="remarks-textarea" placeholder="E.g. No ice, less sugar, less spicy..."></textarea>
  </div>
<?php endif; ?>


  <div class="menu-controls">
    <div class="quantity-controls">
      <button class="quantity-btn minus" data-id="<?= htmlspecialchars($_GET['id']) ?>">−</button>
        <input type="number" class="quantity-input" value="1" min="1" />
        <button class="quantity-btn plus" data-id="<?= htmlspecialchars($_GET['id']) ?>">+</button>

    </div>

    <button class="add-to-cart-btn" data-id="<?= htmlspecialchars($_GET['id']) ?>">
      Add to Cart
    </button>
  </div>
</div>

<!-- Toast Notification -->
<div id="toast" class="toast">
  <div class="toast-message"></div>
</div>

<script src="/TKCafe/public/js/cart.js"></script>
