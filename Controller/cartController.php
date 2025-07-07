<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../db.php';
require_once '../Model/cart.php';
$conn = getConnection(); 

$session_id = session_id();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'add') {
        try {
            $success = addItem(
                $conn,
                (int)$_POST['menu_id'],
                (int)$_POST['quantity'],
                (float)$_POST['price'],
                $session_id,
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

            $success = updateQuantity($conn, $id, $quantity, $session_id);
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
        $success = removeItem($conn, $id, $session_id);
        echo json_encode(['success' => $success]);
        exit;
    }
}

// Handle GET requests
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action === 'list') {
        $items = getItems($conn, $session_id);
        echo json_encode($items);
        exit;
    }

    if ($action === 'count') {
        $items = getItems($conn, $session_id);
        echo json_encode(['count' => count($items)]);
        exit;
    }
}
