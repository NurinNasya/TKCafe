<?php
session_start();
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../error.log');
error_reporting(E_ALL);

require_once __DIR__ . '/../Model/order.php';
require_once __DIR__ . '/../Model/cart.php';
require_once __DIR__ . '/../Model/menu.php';
require_once __DIR__ . '/../db.php';

header('Content-Type: application/json');

$conn = getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // 1. Get order_id from POST (or create a new order if not provided)
        $order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : null;

        if (!$order_id) {
            // Create a new order using your existing createInitialOrder function
            $order_type = $_POST['order_type'] ?? 'dine-in'; // default type if not provided
            $table_id   = $_POST['table_id'] ?? 0;           // default table if not provided
            $order_id = createInitialOrder($conn, null, $order_type, $table_id);
        }

        if (!$order_id) {
            throw new Exception("No order_id provided. Please create an order first.");
        }

        // 2. Get cutlery preference
        $cutlery = isset($_POST['cutlery']) ? (int)$_POST['cutlery'] : 0;

        // 3. Get cart items using order_id
        $cart_items = getItems($conn, $order_id);
        if (empty($cart_items)) {
            throw new Exception("Your cart is empty. Add items before placing order.");
        }

        // 4. Calculate subtotal
        $subtotal = 0;
        foreach ($cart_items as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        // 5. Handle voucher (from POST)
      $voucherAmount = 0;
        $voucherCode = '';
        if (isset($_SESSION['voucher'])) {
            $voucherAmount = floatval($_SESSION['voucher']['amount'] ?? 0);
            $voucherCode = $_SESSION['voucher']['code'] ?? '';
            
            // ✅ Optional: Clear voucher from session after use
            // unset($_SESSION['voucher']);
        }

        // 6. Calculate total with service charge
        $service_charge = $subtotal * 0.10;
        $total = max(0, $subtotal + $service_charge - $voucherAmount);

        // 7. Update order totals
        updateOrderTotals($conn, $order_id, $total, $cart_items, $cutlery, $voucherCode, $voucherAmount);

        // 8. Prepare receipt (matches your original logic)
        $receipt_data = [
            'order' => [
                'id' => $order_id,
                'order_number' => getOrderDetails($conn, $order_id)['order']['order_number'] ?? '',
                'created_at' => getOrderDetails($conn, $order_id)['order']['created_at'] ?? '',
                'order_type' => getOrderDetails($conn, $order_id)['order']['order_type'] ?? '',
                'total' => $total
            ],
            'items' => array_map(function($item) use ($conn) {
                $menuItem = getMenuItemById($conn, $item['menu_id']);
                return [
                    'menu_id' => $item['menu_id'],
                    'name' => $menuItem['name'] ?? 'Item #' . $item['menu_id'],
                    'price' => (float)$item['price'],
                    'quantity' => (int)$item['quantity'],
                    'customizations' => $item['customizations'],
                    'remarks' => $item['remarks'] ?? null
                ];
            }, $cart_items)
        ];

           // 9. Clear cart after order is finalized
        //clearCart($conn, $order_id);

        // 10. Return success with order_id for receipt page
        echo json_encode([
            'success' => true,
            'order_id' => $order_id,
            'redirect' => "/TKCafe/Views/receipt.php?order_id=" . $order_id
        ]);

    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
    exit;
}
http_response_code(405);
echo json_encode(['success' => false, 'error' => 'Method not allowed']);
