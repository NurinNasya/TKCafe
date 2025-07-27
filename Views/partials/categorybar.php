<?php
require_once '../db.php';
require_once '../Model/menu.php';

$conn = getConnection();
$hiddenCategories = getHiddenCategories($conn);

$categories = [
  'best-seller' => 'Best Seller',
  'standard' => 'Ala Carte (Standard)',
  'signature' => 'Ala Carte (Signature)',
  'set-standard' => 'Set Standard Combo',
  'set-signature' => 'Set Signature Combo',
  'masakan-ala' => 'Masakan Panas (Ala Carte)',
  'masakan-side' => 'Masakan Panas (Side Dish)',
  'lokcing' => 'Lokcing (Ala Carte)',
  'western' => 'Western Side Dish (Ala Carte)',
  'air-balang' => 'Air Balang',
  'soft-drinks' => 'Soft Drinks',
  'hot-drinks' => 'Hot Drinks'
];
?>

<div class="category-bar">
  <button class="category active" data-category="all">All</button>

  <?php foreach ($categories as $key => $label): ?>
    <?php if (!in_array($key, $hiddenCategories)): ?>
      <button class="category" data-category="<?= $key ?>"><?= $label ?></button>
    <?php endif; ?>
  <?php endforeach; ?>
</div>
