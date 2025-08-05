<?php
require_once '../db.php';
require_once '../Model/menu.php';

$conn = getConnection();
$hiddenCategories = getHiddenCategories($conn);
$allCategories = getAllCategories($conn);

// $categories = [
//   'best-seller' => 'Best Seller',
//   'standard' => 'Ala Carte (Standard)',
//   'signature' => 'Ala Carte (Signature)',
//   'set-standard' => 'Set Standard Combo',
//   'set-signature' => 'Set Signature Combo',
//   'masakan-ala' => 'Masakan Panas (Ala Carte)',
//   'masakan-side' => 'Masakan Panas (Side Dish)',
//   'lokcing' => 'Lokcing (Ala Carte)',
//   'western' => 'Western Side Dish (Ala Carte)',
//   'air-balang' => 'Air Balang',
//   'soft-drinks' => 'Soft Drinks',
//   'hot-drinks' => 'Hot Drinks'
// ];
?>

<div class="category-bar">
  <button class="category active" data-category="all">All</button>
  
  <?php foreach ($allCategories as $category): ?>
    <?php if (!in_array($category['slug'], $hiddenCategories)): ?>
      <button class="category" data-category="<?= $category['slug'] ?>">
        <?= htmlspecialchars($category['name']) ?>
      </button>
    <?php endif; ?>
  <?php endforeach; ?>
</div>