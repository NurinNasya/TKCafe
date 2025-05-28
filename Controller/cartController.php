<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../db.php';
require_once '../Model/cart.php';

$cartModel = new Cart($conn);
$session_id = session_id();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'add') {
        $menu_id = intval($_POST['menu_id']);
        $quantity = intval($_POST['quantity']);
        $price = floatval(str_replace(['RM', ' '], '', $_POST['price'])); // Fix here

        error_log("Attempting to add: menu_id=$menu_id, qty=$quantity, price=$price"); // Debug
        $success = $cartModel->addItem($menu_id, $quantity, $price, $session_id);
        echo json_encode(['success' => $success]);
        exit;
    }
    // other actions ...
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'list') {
    $items = $cartModel->getItems($session_id);
    echo json_encode($items);
    exit;
}
