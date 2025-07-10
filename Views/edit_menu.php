<?php
require_once '../Model/menu.php';
require_once '../db.php';

$conn = getConnection();

if (!isset($_GET['id'])) {
    echo "No menu ID provided.";
    exit();
}

$id = $_GET['id'];
$menu = getMenuItemById($conn, $id);

if (!$menu) {
    echo "Menu item not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Menu</title>
  <link rel="stylesheet" href="/TKCafe/public/css/admin.css">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Menu Item</h2>
    <form action="/TKCafe/Controller/menuController.php" method="POST" enctype="multipart/form-data" style="max-width: 500px;">
        <input type="hidden" name="id" value="<?= $menu['id'] ?>">

        <div class="form-group mb-3">
            <label>Menu Name</label>
            <input type="text" name="name" class="form-control" value="<?= $menu['name'] ?>" required>
        </div>

        <div class="form-group mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" required><?= $menu['description'] ?></textarea>
        </div>

        <div class="form-group mb-3">
            <label>Price (RM)</label>
            <input type="number" step="0.01" name="price" class="form-control" value="<?= $menu['price'] ?>" required>
        </div>

        <div class="form-group mb-3">
            <label>Category</label>
            <input type="text" name="category" class="form-control" value="<?= $menu['category'] ?>" required>
        </div>

        <div class="form-group mb-3">
            <label>Current Image:</label><br>
            <img src="../uploads/<?= $menu['image'] ?>" width="100"><br><br>
            <input type="file" name="image" class="form-control">
            <small>Leave blank to keep current image.</small>
        </div>

        <button type="submit" name="updateMenu" class="btn btn-success">Update Menu</button>
        <a href="manage_menu.php" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>
