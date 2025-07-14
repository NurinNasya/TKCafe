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

        $cutlery = isset($_POST['cutlery']) ? (int)$_POST['cutlery'] : 0;

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
         
        // handle vouncher from session
        $voucherAmount = 0;
        $voucherCode = '';
        if (isset($_SESSION['voucher']) && is_array($_SESSION['voucher'])) {
            if (isset($_SESSION['voucher']['amount'])) {
                $voucherAmount = floatval($_SESSION['voucher']['amount']);
            }
            if (isset($_SESSION['voucher']['code'])) {
                $voucherCode = $_SESSION['voucher']['code'];
    }
        // if (isset($_SESSION['voucher'])) {
        //     $voucherAmount = $_SESSION['voucher']['amount'] ?? 0
        //     $voucherCode = isset($_SESSION['voucher']['code']) ? $_SESSION['voucher']['code'] : null;
            // $voucherCode = $_SESSION['voucher']['code'] ?? '';
        }

        // calculate total  with discount
        $service_charge = $subtotal * 0.10;
        $total = $subtotal + $service_charge - $voucherAmount;
        $total = max(0, $total); // prevent negative total
        
      

        // 4. Finalize order
        // added voucher code & amount
        updateOrderTotals($conn, $currentOrder['id'], $total, $cart_items, $cutlery ,$voucherCode, $voucherAmount);
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

        // store voucher info in receipt info//
       $_SESSION['last_order'] = [
    'order' => getOrderDetails($conn, $order_id),
    'items' => $receipt_data['items'],
    ];
    $_SESSION['last_order']['order']['voucher_amount'] = $voucherAmount;
    $_SESSION['last_order']['order']['voucher_code'] = $voucherCode;

         
        //clear voucher after placing the order//
        unset($_SESSION['voucher']);

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
