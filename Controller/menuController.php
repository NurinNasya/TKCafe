<?php
require_once '../model/menu.php';
require_once '../db.php'; // ✅ This gives access to getConnection()


$conn = getConnection(); 

// ADD MENU
if (isset($_POST['addMenu'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image']['name'];
        $temp = $_FILES['image']['tmp_name'];
        $target = "../uploads/" . basename($image);

        if (move_uploaded_file($temp, $target)) {
            // Save to database
             if (addMenuItem($conn, $name, $description, $price, $category, $image)) {
            header("Location: ../views/manage_menu.php");
            exit();
        } else {
            echo "Failed to upload image.";
        }
    } else {
        echo "Image is required.";
    }
}

// DELETE MENU
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $menuModel->deleteMenu($id);
    header("Location: ../views/manage_menu.php");
    exit();
}
}
// EDIT and UPDATE could go here later...

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $item = getMenuItemById($conn, $id); // This should be defined in your menu model

    if ($item) {
        require '../views/menu_popup.php';
        exit;
    } else {
        echo "Item not found.";
        exit;
    }
}

?>
