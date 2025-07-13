<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../Model/order.php';
require_once __DIR__ . '/../db.php';

$conn = getConnection();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirectWithError('Invalid request method');
}

if (!isset($_POST['order_type'])) {
    redirectWithError('No order type selected');
}

$orderType = sanitizeOrderType($_POST['order_type']);
$sessionId = session_id();
$tableId = isset($_POST['table_id']) ? intval($_POST['table_id']) : 0; 

try {
    $existingOrder = getCurrentOrderBySession($conn, $sessionId);

    if ($existingOrder) {
        updateOrderType($conn, $sessionId, $orderType);
        $_SESSION['current_order'] = getCurrentOrderBySession($conn, $sessionId);
    } else {
        $orderId = createInitialOrder($conn, $sessionId, $orderType, $tableId);
        $_SESSION['current_order'] = getCurrentOrderBySession($conn, $sessionId);
    }

    $_SESSION['current_order_type'] = $orderType;
    forceRedirect('/TKCafe/Views/menu.php');

} catch (Exception $e) {
    error_log("Order error: " . $e->getMessage());
    redirectWithError('Failed to process selection');
}

// --- Helper functions ---
function sanitizeOrderType($input) {
    return $input === 'dine-in' ? 'dine_in' : 'take_away';
}

function forceRedirect($path) {
    while (ob_get_level()) ob_end_clean();
    $url = 'http://' . $_SERVER['HTTP_HOST'] . $path;
    header("Location: $url");
    exit();
}

function redirectWithError($message) {
    $_SESSION['dinein_takeaway_error'] = $message;
    forceRedirect('/TKCafe/Views/dinein-takeaway.php');
}
