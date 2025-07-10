<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../error.log');
error_reporting(E_ALL);

session_start();
require_once __DIR__ . '/../Model/order.php';
require_once __DIR__ . '/../Model/cart.php';
require_once __DIR__ . '/../Model/menu.php';
require_once __DIR__ . '/../db.php';

header('Content-Type: application/json');

$conn = getConnection();
// $menuModel = new Menu();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // 1. Get current order
        $currentOrder = getCurrentOrderBySession($conn, session_id());
        if (!$currentOrder) {
            throw new Exception("No active order found. Please start ordering from the menu.");
        }

        // 2. Check cart
        $cart_items = getItems($conn, session_id());
        if (empty($cart_items)) {
            throw new Exception("Your cart is empty. Add items before placing order.");
        }

        // 3. Calculate total
        $subtotal = 0;
        foreach ($cart_items as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $service_charge = $subtotal * 0.10;
        $total = $subtotal + $service_charge;

        // 4. Finalize order
        updateOrderTotals($conn, $currentOrder['id'], $total, $cart_items);
        $order_id = $currentOrder['id'];

        // 5. Prepare receipt
        $receipt_data = [
            'order' => [
                'id' => $order_id,
                'order_number' => $currentOrder['order_number'],
                'created_at' => $currentOrder['created_at'],
                'order_type' => $currentOrder['order_type'],
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
            // 'items' => array_map(function($item) use ($menuModel) {
                // $menuItem = $menuModel->getItemById($item['menu_id']);
                // return [
                //     'menu_id' => $item['menu_id'],
                //     'name' => $menuItem['name'] ?? 'Item #' . $item['menu_id'],
                //     'price' => (float)$item['price'],
                //     'quantity' => (int)$item['quantity'],
                //     'customizations' => $item['customizations'],
                //     'remarks' => $item['remarks'] ?? null
                ];
            }, $cart_items)
        ];

        // $_SESSION['last_order'] = $receipt_data;
        $_SESSION['last_order'] = getOrderDetails($conn, $order_id);

        // 6. Clear cart
        clearCart($conn, session_id());

        // 7. Return success
        echo json_encode([
            'success' => true,
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
