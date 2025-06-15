<?php
/*session_start();
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
if ($action === 'update') {
    try {
        $id = intval($_POST['id']);
        $quantity = intval($_POST['quantity']);
        
        if ($id <= 0 || $quantity <= 0) {
            throw new Exception('Invalid ID or quantity');
        }
        
        $success = $cartModel->updateQuantity($id, $quantity, $session_id);
        echo json_encode([
            'success' => $success,
            'error' => $success ? null : 'Update failed in model'
        ]);
    } catch (Exception $e) {
        error_log('Update quantity error: ' . $e->getMessage());
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
    exit;
}

if ($action === 'remove') {
    $id = intval($_POST['id']);
    $success = $cartModel->removeItem($id, $session_id);
    echo json_encode(['success' => $success]);
    exit;
}
}

// Handle GET requests
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action === 'list') {
        $items = $cartModel->getItems($session_id);
        echo json_encode($items);
        exit;
    }

    if ($action === 'count') {
        $items = $cartModel->getItems($session_id);
        echo json_encode(['count' => count($items)]);
        exit;
    }
}*/

/*if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'list') {
    $items = $cartModel->getItems($session_id);
    echo json_encode($items);
    exit;
}*/

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
    try {
        $menu_id = intval($_POST['menu_id']);
        $quantity = intval($_POST['quantity']);
        
        // Handle price - already parsed in JavaScript
        $price = floatval($_POST['price']);
        if ($price <= 0) {
            throw new Exception('Invalid price value');
        }
        
        // Get customizations if they exist
        $customizations = null;
        if (isset($_POST['customizations'])) {
            $customizations = json_decode($_POST['customizations'], true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Invalid customizations format');
            }
        }

        $success = $cartModel->addItem(
            $menu_id, 
            $quantity, 
            $price, 
            $session_id,
            $customizations
        );
        
        echo json_encode([
            'success' => $success,
            'error' => $success ? null : 'Failed to add item to database'
        ]);
    } catch (Exception $e) {
        error_log("Add to cart error: " . $e->getMessage());
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
    exit;
}

    if ($action === 'update') {
        try {
            $id = intval($_POST['id']);
            $quantity = intval($_POST['quantity']);
            
            if ($id <= 0 || $quantity <= 0) {
                throw new Exception('Invalid ID or quantity');
            }
            
            $success = $cartModel->updateQuantity($id, $quantity, $session_id);
            echo json_encode([
                'success' => $success,
                'error' => $success ? null : 'Update failed in model'
            ]);
        } catch (Exception $e) {
            error_log('Update quantity error: ' . $e->getMessage());
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
        exit;
    }

    if ($action === 'remove') {
        $id = intval($_POST['id']);
        $success = $cartModel->removeItem($id, $session_id);
        echo json_encode(['success' => $success]);
        exit;
    }
}

// Handle GET requests
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action === 'list') {
        $items = $cartModel->getItems($session_id);
        echo json_encode($items);
        exit;
    }

    if ($action === 'count') {
        $items = $cartModel->getItems($session_id);
        echo json_encode(['count' => count($items)]);
        exit;
    }
}