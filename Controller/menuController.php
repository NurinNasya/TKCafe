<?php
require_once '../model/menu.php';
require_once '../db.php';

$conn = getConnection(); 

// ADD MENU
if (isset($_POST['addMenu'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image']['name'];
        $temp = $_FILES['image']['tmp_name'];
        $target = "../uploads/" . basename($image);

        if (move_uploaded_file($temp, $target)) {
            if (addMenuItem($conn, $name, $description, $price, $category, $image)) {
                header("Location: ../views/manage_menu.php");
                exit();
            } else {
                echo "Failed to save to database.";
            }
        } else {
            echo "Failed to upload image.";
        }
    } else {
        echo "Image is required.";
    }
}

// UPDATE MENU
if (isset($_POST['updateMenu'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target = "../uploads/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    } else {
        $menu = getMenuItemById($conn, $id); // ✅ use functional version
        $image = $menu['image'];
    }

    updateMenuItem($conn, $id, $name, $description, $price, $category, $image); // ✅ use functional version
    header("Location: ../views/manage_menu.php");
    exit();
}

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

// DELETE MENU
if (isset($_POST['delete_menu'])) {
    $id = $_POST['delete_menu_id'];
    deleteMenuItem($conn, $id);
    header("Location: ../views/manage_menu.php");
    exit();
}

