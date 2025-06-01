<?php if (!isset($item)) {
    echo "No item data.";
    exit;
} ?>

<link rel="stylesheet" href="/TKCafe/public/css/style.css" />

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
    </button>

    <a href="/TKCafe/Views/menu.php" class="back-button">⬅ Back to Menu</a>
  </div>
</div>
