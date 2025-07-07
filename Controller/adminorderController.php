<?php
require_once '../db.php';
require_once '../Model/adminorder.php';

$conn = getConnection();

$action = $_GET['action'] ?? null;
$id = $_GET['id'] ?? null;

if ($action === 'view' && $id) {
    $order = getOrderById($conn, $id); // ✅ Call function directly
    if (!$order) {
        echo "<div class='error'>Order not found</div>";
        exit;
    }

    include '../Views/orders_popup.php';
    exit;
}

// Handle AJAX status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'update_status') {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['status'];

    try {
        $updated = updateOrderStatus($conn, $orderId, $newStatus); // ✅ Call function directly
        echo json_encode(['success' => $updated]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit;
}
