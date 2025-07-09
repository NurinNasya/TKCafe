<?php include 'header.php'; ?> <!-- Optional: your header/nav layout -->

<div class="container mt-5">
    <h2>Add New Menu Item</h2>
    <form action="../controllers/menuController.php" method="POST" enctype="multipart/form-data" style="max-width: 500px;">
        
        <!-- Menu Name -->
        <div class="form-group mb-3">
            <label for="name">Menu Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <!-- Description -->
        <div class="form-group mb-3">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
        </div>

        <!-- Price -->
        <div class="form-group mb-3">
            <label for="price">Price (RM)</label>
            <input type="number" step="0.01" name="price" id="price" class="form-control" required>
        </div>

        <!-- Category -->
        <div class="form-group mb-3">
            <label for="category">Category</label>
            <input type="text" name="category" id="category" class="form-control" required>
        </div>

        <!-- Image Upload -->
        <div class="form-group mb-4">
            <label for="image">Upload Image</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" name="addMenu" class="btn btn-success">Add Menu</button>
        <a href="manage_menu.php" class="btn btn-secondary">Back</a>
    </form>
</div>

<?php include 'footer.php'; ?> <!-- Optional: your footer -->
