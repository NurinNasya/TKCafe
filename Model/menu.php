
<?php

function getAllCategories($conn) {
    $sql = "SELECT * FROM categories ORDER BY id ASC";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}


function getAllMenuItems($conn) {
    $sql = "SELECT * FROM menu ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getMenuItemById($conn, $id) {
    $id = (int)$id;
    $sql = "SELECT * FROM menu WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function getMenuItemsByCategory($conn, $category) {
    $category = mysqli_real_escape_string($conn, $category);
    $sql = "SELECT * FROM menu WHERE category = '$category'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function addMenuItem($conn, $name, $description, $price, $category, $image, $best_seller=0) {
    $name = mysqli_real_escape_string($conn, $name);
    $description = mysqli_real_escape_string($conn, $description);
    $category = mysqli_real_escape_string($conn, $category);
    $image = mysqli_real_escape_string($conn, $image);
    $price = (float)$price;
    $best_seller = (int)$best_seller;

    $sql = "INSERT INTO menu (name, description, price, category, image, best_seller)
            VALUES ('$name', '$description', $price, '$category', '$image', $best_seller)";
    return mysqli_query($conn, $sql);
}

function updateMenuItem($conn, $id, $name, $description, $price, $category, $image, $best_seller) {
    $id = (int)$id;
    $name = mysqli_real_escape_string($conn, $name);
    $description = mysqli_real_escape_string($conn, $description);
    $category = mysqli_real_escape_string($conn, $category);
    $image = mysqli_real_escape_string($conn, $image);
    $price = (float)$price;
     $best_seller = (int)$best_seller;

    $sql = "UPDATE menu SET name='$name', description='$description', price=$price, 
            category='$category', image='$image', best_seller=$best_seller WHERE id=$id";
    return mysqli_query($conn, $sql);
}

function getBestSellerItems($conn) {
    $sql = "SELECT * FROM menu WHERE best_seller = 1 ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getHiddenCategories($conn) {
    $sql = "SELECT category_name FROM hidden_category";
    $result = mysqli_query($conn, $sql);
    $categories = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row['category_name'];
    }
    return $categories;
}

function hideCategory($conn, $category) {
    $category = mysqli_real_escape_string($conn, $category);
    $sql = "INSERT IGNORE INTO hidden_category (category_name) VALUES ('$category')";
    return mysqli_query($conn, $sql);
}

function showCategory($conn, $category) {
    $category = mysqli_real_escape_string($conn, $category);
    $sql = "DELETE FROM hidden_category WHERE category_name = '$category'";
    return mysqli_query($conn, $sql);
}

function deleteMenuItem($conn, $id) {
    $id = (int)$id;
    $sql = "DELETE FROM menu WHERE id = $id";
    return mysqli_query($conn, $sql);
}

function categoryExists($conn, $slug) {
    $slug = mysqli_real_escape_string($conn, $slug);
    $sql = "SELECT id FROM categories WHERE slug = '$slug'";
    $result = mysqli_query($conn, $sql);
    return mysqli_num_rows($result) > 0;
}

function insertCategory($conn, $name, $slug) {
    $name = mysqli_real_escape_string($conn, $name);
    $slug = mysqli_real_escape_string($conn, $slug);
    $sql = "INSERT INTO categories (name, slug) VALUES ('$name', '$slug')";
    return mysqli_query($conn, $sql);
}