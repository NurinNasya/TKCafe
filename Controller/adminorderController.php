<?php
require_once '../db.php';
require_once '../Model/adminorder.php';

$action = $_GET['action'] ?? null;
$id = $_GET['id'] ?? null;

$model = new AdminOrderModel($conn);

if ($action === 'view' && $id) {
    $order = $model->getOrderById($id);
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

    require_once '../Model/adminorder.php';
    $model = new AdminOrderModel($conn);

    try {
        $updated = $model->updateStatus($orderId, $newStatus);
        echo json_encode(['success' => $updated]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit;
}

// if ($action === 'complete' && $id) {
//     $success = $model->markOrderComplete($id);
//     echo json_encode(['success' => $success]);
//     exit;
// }

// require_once __DIR__ . '/../Model/adminorder.php';

// class AdminOrderController {
//     private $model;
    
//     public function __construct(mysqli $db) {
//         $this->model = new AdminOrderModel($db);
//     }

//     public function showOrders() {
//         try {
//             $orders = $this->model->getAllOrdersWithItems();
            
//             if (!file_exists(__DIR__ . '/../Views/orders.php')) {
//                 throw new RuntimeException('Orders view template missing');
//             }
            
//             // Make data available to view
//             require __DIR__ . '/../Views/orders.php';
            
//         } catch (Exception $e) {
//             error_log('AdminOrderController Error: ' . $e->getMessage());
//             throw $e;
//         }
//     }

// }







// File: /TKCafe/Controller/adminorderController.php

// require_once __DIR__ . '/../Model/adminorder.php';

// class AdminOrderController {
//     private $model;
    
//     public function __construct($db) {
//         $this->model = new AdminOrderModel($db);
//     }

//     public function showOrders() {
//         try {
//             $orders = $this->model->getAllOrdersWithItems();
            
//             // Calculate absolute path to views
//             $viewsPath = realpath(__DIR__ . '/../Views');
//             if (!$viewsPath) {
//                 throw new Exception("Views directory not found");
//             }
            
//             $viewFile = $viewsPath . '/admin/orders.php';
//             if (!file_exists($viewFile)) {
//                 throw new Exception("View file not found at: " . $viewFile);
//             }
            
//             // Make variables available to view
//             $viewVars = [
//                 'orders' => $orders,
//                 'adminViewPath' => $viewsPath . '/admin/' // Pass path for assets
//             ];
            
//             extract($viewVars);
//             require $viewFile;
            
//         } catch (Exception $e) {
//             $this->handleError($e);
//         }
//     }

/*require_once __DIR__ . '/../Model/adminorder.php';

class AdminOrderController {
    private $model;
    
    public function __construct($db) {
        $this->model = new AdminOrderModel($db);
    }

    public function showOrders() {
        $orders = $this->model->getAllOrdersWithItems();
        
        // Try these possible paths in order
        $possiblePaths = [
            // If Views is at same level as Controller
            __DIR__ . '/../Views/admin/orders.php',
            // If View is at same level as Controller (singular)
            __DIR__ . '/../View/admin/orders.php',
            // If Views is at root level
            __DIR__ . '/../../Views/admin/orders.php',
            // If View is at root level (singular)
            __DIR__ . '/../../View/admin/orders.php'
        ];
        
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                require $path;
                return;
            }
        }
        
        // If we get here, no path worked
        die("View file not found. Tried these locations:<br>" . 
            implode("<br>", array_map('htmlspecialchars', $possiblePaths)));
    }
}*/