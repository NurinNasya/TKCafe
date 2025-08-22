<?php
require_once '../db.php';
require_once '../Model/menu.php';

$conn = getConnection();
$hiddenCategories = getHiddenCategories($conn);
$allCategories = getAllCategories($conn);
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