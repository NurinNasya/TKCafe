<?php
include_once '../Model/menu.php'; 
require_once '../db.php';

$conn = getConnection(); 
$menuItems = getAllMenuItems($conn);
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

    <!-- Table List with Add Button -->
    <section class="data-section">
      <div class="section-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h2>Menu List</h2>
        <button class="btn btn-primary" onclick="openAddForm()">+ Add Menu</button>
      </div>

      <div class="table-container">
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
              <?php foreach ($menuItems as $menu) : ?>
              <tr>
                <td><?= htmlspecialchars($menu['id']) ?></td>
                <td><?= htmlspecialchars($menu['name']) ?></td>
                <td><?= htmlspecialchars($menu['description']) ?></td>
                <td>RM <?= number_format($menu['price'], 2) ?></td>
                <td><img src="/TKCafe/uploads/<?= htmlspecialchars($menu['image']) ?>" width="50" alt="Menu Image"></td>
                <td><?= htmlspecialchars($menu['category']) ?></td>
                <td>
                 <a href="edit_menu.php?id=<?= $menu['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
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
      </div>
    </section>

    <!-- Add Menu Popup Modal -->
    <div id="addMenuModal" class="modal">
      <div class="modal-content">
        <span class="close" onclick="closeAddForm()">&times;</span>
        <h2>Add New Menu Item</h2>
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
                <input type="number" name="price" step="0.01" required>
            </div>

        <div class="form-group">
        <label>Category</label>
        <select name="category" required>
        <option value="" disabled selected>Select Category</option>
        <option value="best-seller">Best Seller</option>
        <option value="standard">Ala Carte (Standard)</option>
        <option value="signature">Ala Carte (Signature)</option>
        <option value="set-standard">Set Standard Combo</option>
        <option value="set-signature">Set Signature Combo</option>
        <option value="masakan-ala">Masakan Panas (Ala Carte)</option>
        <option value="masakan-side">Masakan Panas (Side Dish)</option>
        <option value="lokcing">Lokcing (Ala Carte)</option>
        <option value="western">Western Side Dish (Ala Carte)</option>
        <option value="air-balang">Air Balang</option>
        <option value="soft-drinks">Soft Drinks</option>
        <option value="hot-drinks">Hot Drinks</option>
    
       </select>
       </div>

            <div class="form-group">
                <label>Upload Image</label>
                <input type="file" name="image" accept="image/*" required>
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
        <textarea name="description" id="edit-description" rows="3" required></textarea>
      </div>

      <div class="form-group">
        <label>Price (RM)</label>
        <input type="number" name="price" id="edit-price" step="0.01" required>
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

      <div class="form-buttons">
        <button type="submit" name="updateMenu" class="btn btn-success">Update Menu</button>
        <button type="button" onclick="closeEditForm()" class="btn btn-secondary">Cancel</button>
      </div>
    </form>
  </div>
</div>

  </main>
</div>

<!-- Link to your external JS file -->
<script src="/TKCafe/public/js/admin_menu.js"></script>
</body>
</html>