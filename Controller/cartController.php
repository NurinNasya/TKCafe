<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../db.php';
require_once '../Model/cart.php';
$conn = getConnection(); 


// ✅ ADD DEBUG CODE HERE
error_log("=== CART CONTROLLER DEBUG ===");
error_log("DEBUG: Order ID from POST: " . ($_POST['order_id'] ?? 'NULL'));
error_log("DEBUG: Order ID from GET: " . ($_GET['order_id'] ?? 'NULL'));
error_log("DEBUG: Order ID from SESSION: " . ($_SESSION['current_order']['id'] ?? 'NULL'));
error_log("DEBUG: Full SESSION: " . json_encode($_SESSION));

// ✅ Get order_id from POST, GET, or fallback to session
$order_id = $_POST['order_id'] ?? $_GET['order_id'] ?? ($_SESSION['current_order']['id'] ?? null);
$order_id = $order_id ? intval($order_id) : null;

error_log("DEBUG: Final Order ID being used: " . $order_id); // Add this too

// Only fail if order_id truly doesn't exist
if (!$order_id) {
    error_log("ERROR: No order_id found anywhere!");
    echo json_encode(['success' => false, 'error' => 'Missing order ID']);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'add') {
        try {
            $success = addItem(
                $conn,
                $order_id,
                (int)$_POST['menu_id'],
                (int)$_POST['quantity'],
                (float)$_POST['price'],
                isset($_POST['customizations']) ? json_decode($_POST['customizations'], true) : null,
                $_POST['remarks'] ?? null
            );

            echo json_encode(['success' => $success]);
        } catch (Exception $e) {
            http_response_code(400);
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

            $success = updateQuantity($conn, $id, $quantity, $order_id);
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
        $success = removeItem($conn, $id, $order_id);
        echo json_encode(['success' => $success]);
        exit;
    }
}

// Handle GET requests
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action === 'list') {
        $items = getItems($conn, $order_id);
        echo json_encode($items);
        exit;
    }

    if ($action === 'count') {
        $items = getItems($conn, $order_id);
        echo json_encode(['count' => count($items)]);
        exit;
    }
}
