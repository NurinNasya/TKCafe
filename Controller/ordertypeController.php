<?php
session_start();
error_log("Controller accessed: " . date('Y-m-d H:i:s'));
error_log("REQUEST METHOD: " . $_SERVER['REQUEST_METHOD']);
error_log("POST DATA: " . print_r($_POST, true));
// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../Model/order.php';
require_once __DIR__ . '/../db.php';

class ordertypeController {
    private $orderModel;
    
    public function __construct() {
        global $conn;
        $this->orderModel = new Order($conn);
    }

    public function handleSelection() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectWithError('Invalid request method');
        }

        if (!isset($_POST['order_type'])) {
            $this->redirectWithError('No order type selected');
        }

        $orderType = $this->sanitizeOrderType($_POST['order_type']);
        $sessionId = session_id();

        try {
            $existingOrder = $this->orderModel->getCurrentOrderBySession($sessionId);

            if ($existingOrder) {
                $this->orderModel->updateOrderType($sessionId, $orderType);
            } else {
                $this->orderModel->createInitialOrder($sessionId, $orderType);
            }

            $_SESSION['current_order_type'] = $orderType;
            $this->forceRedirect('/TKCafe/Views/menu.php');

        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            $this->redirectWithError('Failed to process selection');
        }
    }

    private function sanitizeOrderType($input) {
        return $input === 'dine-in' ? 'dine_in' : 'take_away';
    }

    private function forceRedirect($path) {
        // Clear output buffers
        while (ob_get_level()) ob_end_clean();
        
        // Build absolute URL
        $url = 'http://' . $_SERVER['HTTP_HOST'] . $path;
        
        // Redirect
        header("Location: $url");
        exit();
    }

    private function redirectWithError($message) {
        $_SESSION['dinein_takeaway_error'] = $message;
        $this->forceRedirect('/TKCafe/Views/dinein-takeaway.php');
    }
}

// Execute
try {
    $controller = new ordertypeController();
    $controller->handleSelection();
} catch (Exception $e) {
    error_log("Fatal error: " . $e->getMessage());
    header("HTTP/1.1 500 Internal Server Error");
    die('System error');
}
?>