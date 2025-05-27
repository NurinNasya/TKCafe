<?php

require_once '../Model/menu.php'; // Adjust path based on your folder structure

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$menu = new Menu();

// --- AJAX request handling start ---
if (isset($_GET['id']) && isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) {
    $id = intval($_GET['id']);
    $item = $menu->getItemById($id);

    if ($item) {
        header('Content-Type: application/json');
        echo json_encode([
            'name' => $item['name'],
            'price' => $item['price'],
            'description' => $item['description'],
            'image' => $item['image'], // adjust key name as needed
        ]);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Item not found']);
    }
    exit;  // Important: stop the script here for AJAX requests
}
// --- AJAX request handling end ---


if (!isset($_GET['id'])) {
    echo "No menu item selected.";
    exit;
}

$id = intval($_GET['id']);
$item = $menu->getItemById($id);

if (!$item) {
    echo "Menu item not found.";
    exit;
}

// Optionally, you can check category to load different views
$category = $item['category'] ?? 'standard';

if ($category === 'signature') {
    include '../Views/menuitem_signature.php';  // If you have a different view for signature items
} else {
    include '../Views/menuitem_standard.php';
}