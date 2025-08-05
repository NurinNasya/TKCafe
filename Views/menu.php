<?php
session_start();
require_once '../db.php';           
require_once '../Model/menu.php';
$conn = getConnection();
$menuItems = getAllMenuItems($conn);
$hiddenCategories = getHiddenCategories($conn);
$bestSellerItems = getBestSellerItems($conn); // Get bestsellers separately
?>

<?php require 'partials/header.php'; ?>
<?php require 'partials/categorybar.php'; ?>

<link rel="stylesheet" href="/TKCafe/public/css/style.css">

<!-- Menu items container -->
<div class="menu-items">

    <!-- BEST SELLERS SECTION (always shows at top) -->
    <?php if (!empty($bestSellerItems)): ?>
        <!-- <h2 class="menu-section-title">Bestsellers</h2> -->
        <?php foreach ($bestSellerItems as $item): ?>
            <div class="menu-item best-seller-highlight" data-category="<?= htmlspecialchars($item['category']) ?>">
                <div class="best-seller-badge">Bestseller</div>
                <img src="/TKCafe/uploads/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="menu-item-img" />
                <div class="menu-item-info">
                    <div>
                        <h3><?= htmlspecialchars($item['name']) ?></h3>
                        <p><?= htmlspecialchars($item['description']) ?></p>
                        <div class="menu-item-price">RM<?= number_format($item['price'], 2) ?></div>
                    </div>
                    <div>
                        <button class="select-btn" data-id="<?= $item['id'] ?>">Select</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- REGULAR CATEGORIES -->
    <?php
    $allCategories = getAllCategories($conn);

    // $categoryOrder = [
    //     'best-seller', // This will now only contain non-bestseller items from best-seller category
    //     'standard',
    //     'signature',
    //     'set-standard',
    //     'set-signature',
    //     'masakan-ala',
    //     'masakan-side',
    //     'lokcing',
    //     'western',
    //     'air-balang',
    //     'soft-drinks',
    //     'hot-drinks'
    // ];

    if (!empty($menuItems)):
        // foreach ($categoryOrder as $category):
             foreach ($allCategories as $catData):
            $category = $catData['slug'] ?? $catData['name']; 
              //$category = $catData['slug'];  or 'name', depending on your DB structure
            if (in_array($category, $hiddenCategories)) continue;
            foreach ($menuItems as $item):
                // Skip if this is a bestseller item (already shown above)
                if (in_array($item['id'], array_column($bestSellerItems, 'id'))) continue;
                if ($item['category'] === $category): ?>
                    <div class="menu-item" data-category="<?= htmlspecialchars($item['category']) ?>">
                        <img src="/TKCafe/uploads/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="menu-item-img" />
                        <div class="menu-item-info">
                            <div>
                                <h3><?= htmlspecialchars($item['name']) ?></h3>
                                <p><?= htmlspecialchars($item['description']) ?></p>
                                <div class="menu-item-price">RM<?= number_format($item['price'], 2) ?></div>
                            </div>
                            <div>
                                <button class="select-btn" data-id="<?= $item['id'] ?>">Select</button>
                            </div>
                        </div>
                    </div>
                <?php endif;
            endforeach;
        endforeach;
    else: ?>
        <p>No menu items found.</p>
    <?php endif; ?>
</div>

<!-- Rest of your existing popup/overlay code -->
<div id="overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999;"></div>
<div id="popup" style="display:none; position:fixed; top:20%; left:50%; transform:translateX(-50%); background:#fff; padding:20px; border:1px solid #ccc; z-index:1000; max-width:700px;"></div>  

<?php require 'partials/footer.php'; ?>

<script src="/TKCafe/public/js/menu.js"></script>
<script src="/TKCafe/public/js/cart.js"></script>
<script src="/TKCafe/public/js/category.js"></script>