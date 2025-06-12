
<!--<link rel="stylesheet" href="/TKCafe/public/css/style.css" />

<div class="menu-details-container">
  <h1 class="menu-title"><?= htmlspecialchars($item['name']) ?></h1>

  <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="menu-image" />

  <p class="menu-description"><?= htmlspecialchars($item['description']) ?></p>

  <p class="menu-price">
    <strong>Price:</strong> <?= htmlspecialchars($item['price']) ?>
  </p>

  <div class="menu-controls">
    <div class="quantity-controls">
      <button class="quantity-btn minus">−</button>
      <input type="number" class="quantity-input" value="1" min="1" />
      <button class="quantity-btn plus">+</button>
    </div>

    <button class="add-to-cart-btn" data-id="<?= htmlspecialchars($_GET['id']) ?>">
      Add to Cart
    </button>-->

    <!--<div id="toast" class="toast">
    <div class="toast-message">Added to Cart!</div>
    </div>-->

    <!--<a href="/TKCafe/Views/menu.php" class="back-button">⬅ Back to Menu</a>-->
  <!--</div>
</div>-->

<?php if (!isset($item)) {
    echo "No item data.";
    exit;
} ?>

<link rel="stylesheet" href="/TKCafe/public/css/style.css" />

<div class="menu-details-container">
  <h1 class="menu-title"><?= htmlspecialchars($item['name']) ?></h1>

  <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="menu-image" />

  <p class="menu-description"><?= htmlspecialchars($item['description']) ?></p>

  <?php 
  // Check if this is a combo set (either standard or signature)
  $isCombo = strpos($item['category'], 'set-') === 0;
  ?>

  <?php if ($isCombo): ?>
    <!-- COMBO CUSTOMIZATION SECTION -->
    <div class="combo-customization">
      <h3>Customize Your Combo</h3>
      
      <div class="customization-option">
        <label>Drink Selection:</label> <!--sini haziqah -->>
        <select class="drink-select">
          <option value="pepsi">Pepsi</option>
          <option value="coke">Coca-Cola</option>
          <option value="sprite">Sprite</option>
          <option value="orange">Orange Juice</option>
          <option value="tea">Iced Tea</option>
        </select>
      </div>
  <?php endif; ?>

  <p class="menu-price">
    <strong>Price:</strong> <?= htmlspecialchars($item['price']) ?>
  </p>

  <div class="menu-controls">
    <div class="quantity-controls">
      <button class="quantity-btn minus">−</button>
      <input type="number" class="quantity-input" value="1" min="1" />
      <button class="quantity-btn plus">+</button>
    </div>

    <button class="add-to-cart-btn" data-id="<?= htmlspecialchars($_GET['id']) ?>">
      Add to Cart
    </button>
  </div>
</div>
