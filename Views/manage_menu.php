<?php
include_once '../Model/menu.php'; 
require_once '../db.php';

$conn = getConnection(); 
$menuItems = getAllMenuItems($conn);
$allCategories = getAllCategories($conn);

$hiddenCategories = getHiddenCategories($conn);

$itemsPerPage = 10;
$totalItems = count($menuItems);
$totalPages = ceil($totalItems / $itemsPerPage);

// Get current page from URL, default to 1
$currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$currentPage = min($totalPages, $currentPage); // Clamp to max page

$startIndex = ($currentPage - 1) * $itemsPerPage;
$menuItemsToShow = array_slice(array_reverse($menuItems), $startIndex, $itemsPerPage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Menu</title>
  <link rel="stylesheet" href="/TKCafe/public/css/admin.css">
</head>
<body>
<div class="admin-container">
  <?php require 'partials/sidebar.php'; ?>

  <main class="main-content">
    <header class="top-header">
      <h1>Manage Menu</h1>
    </header>

       <!-- 🟣 Hide/Show Category Section -->
            <div class="toggle-section">
            <h3>Hide / Show Categories</h3>
            <p>
              (click to show or hide categories 
              [<span class="status-indicator status-on"></span> = ON / 
              <span class="status-indicator status-off"></span> = OFF])
            </p>

            <div class="category-grid" id="categoryGrid">
              <?php foreach ($allCategories as $index => $cat): ?>
                <div class="category-toggle <?= $index >= 6 ? 'hidden-category' : '' ?>">
                  <label class="toggle-label">
                    <span class="category-name"><?= htmlspecialchars($cat['name']) ?></span>
                    <label class="switch">
                      <input type="checkbox" 
                            class="category-toggle-checkbox" 
                            data-category="<?= htmlspecialchars($cat['slug']) ?>"
                            <?= in_array($cat['slug'], $hiddenCategories) ? 'checked' : '' ?>>
                      <span class="slider round"></span>
                    </label>
                  </label>
                </div>
              <?php endforeach; ?>
            </div>

            <?php if (count($allCategories) > 6): ?>
              <div class="toggle-more-wrapper">
                <span id="toggleCategoryBtn" class="toggle-more-link">Show More</span>
              </div>
            <?php endif; ?>
          </div>
          
    <!-- Table List with Add Button -->
    <section class="data-section">
      <div class="section-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h2>Menu List</h2>
        <button class="btn btn-primary" onclick="openAddForm()">+ Add Menu</button>
      </div>

      <div class="table-container">

      <div style="margin-bottom: 1rem; text-align: right;">
      <input type="text" id="menuSearchInput" placeholder="Search menu by name, category, or description..." style="padding: 8px; width: 100%; max-width: 400px; border-radius: 4px; border: 1px solid #ccc;">
    </div>
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Menu</th>
              <th>Description</th>
              <th>Price</th>
              <th>Image</th>
              <th>Category</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
              <?php if (!empty($menuItems)) : ?>
               <?php $counter = $startIndex + 1; foreach ($menuItemsToShow as $menu) : ?>


          <tr>
                <td><?= $counter++ ?></td> <!-- Row number -->
                <td><?= htmlspecialchars($menu['name']) ?></td>
                <td><?= htmlspecialchars($menu['description']) ?></td>
                <td>RM <?= number_format($menu['price'], 2) ?></td>
                <td>
                    <img src="/TKCafe/uploads/<?= htmlspecialchars($menu['image']) ?>" 
                        width="50" 
                        alt="Menu Image" 
                        class="popup-image" 
                        data-image="/TKCafe/uploads/<?= htmlspecialchars($menu['image']) ?>">
                  </td>

                <td><?= htmlspecialchars($menu['category']) ?></td>
                <td>
                 <button type="button" class="btn btn-sm btn-primary edit-menu"data-menu='<?= json_encode($menu) ?>'>Edit</button>
                  <form action="/TKCafe/Controller/menuController.php" method="POST" style="display:inline;">
                    <input type="hidden" name="delete_menu_id" value="<?= $menu['id'] ?>">
                    <button type="submit" name="delete_menu" class="btn btn-sm btn-danger"
                      onclick="return confirm('Are you sure you want to delete this menu?');">Delete</button>
                  </form>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php else : ?>
              <tr><td colspan="7" style="text-align: center;">No menu items found.</td></tr>
            <?php endif; ?>
          </tbody>

        </table>

            <div class="pagination">
              <?php if ($currentPage > 1): ?>
                <a href="?page=<?= $currentPage - 1 ?>" class="btn btn-sm">Prev</a>
              <?php endif; ?>

              <?php
              $maxDisplay = 5;
              $start = max(1, $currentPage - 2);
              $end = min($totalPages, $currentPage + 2);

              if ($start > 1) {
                echo '<a href="?page=1" class="btn btn-sm">1</a>';
                if ($start > 2) echo '<span class="dots">...</span>';
              }

              for ($i = $start; $i <= $end; $i++) {
                $activeClass = ($i == $currentPage) ? 'btn-primary' : '';
                echo "<a href='?page=$i' class='btn btn-sm $activeClass'>$i</a>";
              }

              if ($end < $totalPages) {
                if ($end < $totalPages - 1) echo '<span class="dots">...</span>';
                echo "<a href='?page=$totalPages' class='btn btn-sm'>$totalPages</a>";
              }
              ?>

              <?php if ($currentPage < $totalPages): ?>
                <a href="?page=<?= $currentPage + 1 ?>" class="btn btn-sm">Next</a>
              <?php endif; ?>
            </div>

  
    </section>

    <!-- Add Menu Popup Modal -->
    <div id="addMenuModal" class="modal">
      <div class="modal-content">
        <span class="close" onclick="closeAddForm()">&times;</span>
        <h2>Add New Menu </h2>
        <form action="/TKCafe/Controller/menuController.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Menu Name</label>
                <input type="text" name="name" required>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="3"></textarea>
            </div>

               <div class="form-group">
              <label>Price (RM)</label>
             <input type="number" name="price" step="0.01" min="0" required>
              </div>

        <div class="form-group">
        <label>Category</label>
        <select name="category" id="categorySelect" required>
        <option value="" disabled selected>Select Category</option>
        <?php foreach ($allCategories as $cat): ?>
        <option value="<?= htmlspecialchars($cat['slug']) ?>">
        <?= htmlspecialchars($cat['name']) ?>
        </option>
        <?php endforeach; ?>
        <option value="__other__">Other</option>
       </select>

       
       <div class="form-group" id="newCategoryInput" style="display: none;">
        <label>New Category Name</label>
        <input type="text" name="custom_category" id="customCategoryInput">
    </div>
       </div>

            <div class="form-group">
                <label>Upload Image</label>
                <input type="file" name="image" accept="image/*">
            </div>

                  <div class="form-group">
                <label>Remarks as Best Seller:</label>
                <div class="best-seller-toggle">
                  <input type="hidden" name="best_seller" value="0">
                  <input type="checkbox" id="addBestSellerToggle" name="best_seller" value="1" onclick="toggleBestSeller(this)">
                  <label for="addBestSellerToggle" class="toggle-btn"></label>
                  <span class="toggle-label">Best Seller</span>
                </div>
              </div>
            <div class="form-buttons">
                <button type="submit" name="addMenu" class="btn btn-success">Add Menu</button>
                <button type="button" onclick="closeAddForm()" class="btn btn-secondary">Cancel</button>
            </div>
        </form>
      </div>
    </div>

<!-- Edit Menu Popup Modal -->
<div id="editMenuModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeEditForm()">&times;</span>
    <h2>Edit Menu Item</h2>
    <form id="editMenuForm" action="/TKCafe/Controller/menuController.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" id="edit-id">

      <div class="form-group">
        <label>Menu Name</label>
        <input type="text" name="name" id="edit-name" required>
      </div>

      <div class="form-group">
        <label>Description</label>
        <textarea name="description" id="edit-description" rows="3" ></textarea>
      </div>

      <div class="form-group">
        <label>Price (RM)</label>
        <input type="text" name="price" id="edit-price" step="0.01" required>
      </div>

      <div class="form-group">
        <label>Category</label>
        <input type="text" name="category" id="edit-category" required>
      </div>

      <div class="form-group">
        <label>Current Image:</label><br>
        <img id="edit-preview-image" src="" width="100"><br><br>
        <input type="file" name="image">
        <small>Leave blank to keep current image.</small>
      </div>

      <div class="form-group">
        <label>Remarks as Best Seller:</label>
        <div class="best-seller-toggle">
          <input type="checkbox" id="editBestSellerToggle" name="best_seller" value="1">
          <!-- <input type="checkbox" id="editBestSellerToggle" name="best_seller" value="1" onclick="toggleBestSeller(this)"> -->
          <label for="editBestSellerToggle" class="toggle-btn"></label>
          <span class="toggle-label">Best Seller</span>
        </div>
      </div>
      
      <div class="form-buttons">
        <button type="submit" name="updateMenu" class="btn btn-success">Update Menu</button>
        <button type="button" onclick="closeEditForm()" class="btn btn-secondary">Cancel</button>
      </div>
    </form>
  </div>
</div>


<!-- Image Popup Modal -->
<div id="imageModal" class="modal" style="display: none;">
  <div class="modal-content" style="max-width: 600px; position: relative; text-align: center;">
    <span class="close" onclick="closeImageModal()">&times;</span>
    <img id="popupImage" src="" alt="Full Size" style="max-width: 100%; border-radius: 8px;">
  </div>
</div>


  </main>
</div>

<!-- Link to your external JS file -->
<script src="/TKCafe/public/js/admin_menu.js"></script>
</body>
</html>