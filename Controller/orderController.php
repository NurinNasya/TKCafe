<?php
ini_set('display_errors', 0); // hide errors from browser
ini_set('log_errors', 1);     // log errors to file
ini_set('error_log', __DIR__ . '/../error.log'); // change path if needed
error_reporting(E_ALL);


session_start();
require_once __DIR__ . '/../Model/order.php';
require_once __DIR__ . '/../Model/cart.php';
require_once __DIR__ . '/../Model/menu.php';
require_once __DIR__ . '/../db.php';


header('Content-Type: application/json');

$orderModel = new Order($conn);
$cartModel = new Cart($conn);
$menuModel = new Menu();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // 1. Get active order (must exist)
        // $currentOrder = $_SESSION['current_order'] ?? null;
         $currentOrder = $orderModel->getCurrentOrderBySession(session_id());
        if (!$currentOrder) {
            throw new Exception("No active order found. Please start ordering from the menu.");
        }

        // 2. Validate cart has items
        $cart_items = $cartModel->getItems(session_id());
        if (empty($cart_items)) {
            throw new Exception("Your cart is empty. Add items before placing order.");
        }

        // 3. Simple total calculation (no payment logic)
        $subtotal = 0;
        foreach ($cart_items as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $service_charge = $subtotal * 0.10;
        $total = $subtotal + $service_charge;

    // 4. Finalize existing order
            $orderModel->updateOrderTotals(
                $currentOrder['id'],
                $total,
                $cart_items
            );
            $order_id = $currentOrder['id'];

            // 5. Prepare receipt data
           $receipt_data = [
    'order' => [
        'id' => $order_id,
        'order_number' => $currentOrder['order_number'],
        'created_at' => $currentOrder['created_at'],
        'order_type' => $currentOrder['order_type'],
        'total' => $total
    ],
    'items' => array_map(function($item) use ($menuModel) {
        $menuItem = $menuModel->getItemById($item['menu_id']);
        return [
            'menu_id' => $item['menu_id'], // MUST include this
            'name' => $menuItem['name'] ?? 'Item #'.$item['menu_id'],
            'price' => (float)$item['price'],
            'quantity' => (int)$item['quantity'],
            'customizations' => $item['customizations'],
            // 'customizations' => !empty($item['customizations']) 
            //     ? json_decode($item['customizations'], true) 
            //     : null,
            'remarks' => $item['remarks'] ?? null
        ];
    }, $cart_items)
];

// Then store in session
$_SESSION['last_order'] = $receipt_data;
                /*'items' => array_map(function($item) use ($menuModel) {
                    $menuItem = $menuModel->getItemById($item['menu_id']);
                    return [
                        'name' => $menuItem['name'] ?? 'Item #'.$item['menu_id'],
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                        'customizations' => !empty($item['customizations']) 
                            ? json_decode($item['customizations'], true) 
                            : null,
                        'remarks' => $item['remarks'] ?? null
                    ];
                }, $cart_items)*/
        // 4. Finalize order (status remains 'preparing')
        /*$orderModel->updateOrderTotals(
            $currentOrder['id'],
            $total,
            $cart_items
        );

        // 5. Prepare receipt data
        $receipt_data = [
            'order' => [
                'id' => $currentOrder['id'],
                'order_number' => $currentOrder['order_number'],
                'created_at' => date('Y-m-d H:i:s'),
                'order_type' => $currentOrder['order_type'],
                'total' => $total,
                'subtotal' => $subtotal,
                'service_charge' => $service_charge
            ],
            'items' => array_map(function($item) use ($menuModel) {
                $menuItem = $menuModel->getItemById($item['menu_id']);
                return [
                    'name' => $menuItem['name'] ?? 'Item #'.$item['menu_id'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'customizations' => !empty($item['customizations']) ? 
                        json_decode($item['customizations'], true) : null
                ];
            }, $cart_items)
        ];*/

        // 6. Clear cart
        $cartModel->clearCart(session_id());

        // 7. Return success with redirect
        echo json_encode([
            'success' => true,
            'redirect' => "/TKCafe/Views/receipt.php?order_id=".$currentOrder['id']
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

// Not a POST request
http_response_code(405);
echo json_encode(['success' => false, 'error' => 'Method not allowed']);
/*session_start();
require_once __DIR__ . '/../Model/order.php';
require_once __DIR__ . '/../Model/cart.php';
require_once __DIR__ . '/../Model/menu.php';
require_once __DIR__ . '/../db.php';

$orderModel = new Order($conn);
$cartModel = new Cart($conn);
$menuModel = new Menu();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // 1. Get current cart items
        $cart_items = $cartModel->getItems(session_id());
        
        if (empty($cart_items)) {
            throw new Exception("Your cart is empty");
        }

        // 2. Get order type from database
        $currentOrder = $orderModel->getCurrentOrderBySession(session_id());
        
        if (empty($currentOrder) || empty($currentOrder['order_type'])) {
            throw new Exception("Please select Dine-In or Take Away first");
        }
        
        $orderType = $currentOrder['order_type'];

        // 3. Calculate total
        $total = 0;
        foreach ($cart_items as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // 4. Create order
        $order_id = $orderModel->createOrder(
            session_id(),
            $orderType,
            $total,
            $cart_items
        );
        
        // 5. Prepare order details
        $order_details = [
            'order' => [
                'id' => $order_id,
                'order_number' => '#' . $order_id,
                'created_at' => date('Y-m-d H:i:s'),
                'order_type' => $orderType,
                'total' => $total
            ],
            'items' => array_map(function($item) use ($menuModel) {
                $menuItem = $menuModel->getItemById($item['menu_id']);
                return [
                    'name' => $menuItem['name'] ?? 'Item #'.$item['menu_id'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'customizations' => !empty($item['customizations']) ? 
                        json_decode($item['customizations'], true) : null
                ];
            }, $cart_items)
        ];

        // 6. Store in session as backup
        $_SESSION['last_order'] = $order_details;
        
        // 7. Clear cart
        $cartModel->clearCart(session_id());
        
        // 8. Return success
        echo json_encode([
            'success' => true,
            'order_id' => $order_id,
            'redirect' => "/TKCafe/Views/receipt.php?order_id=$order_id"
        ]);

    } catch (Exception $e) {
        error_log("Order Error: " . $e->getMessage());
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
    exit;
}sec*/




/*session_start();
require_once '../Model/order.php';
require_once '../Model/cart.php';
require_once '../Model/menu.php';
require_once '../db.php';

$orderModel = new Order($conn);
$cartModel = new Cart($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
    // 1. FIRST get cart items
    $cart_items = $cartModel->getItems(session_id());
    
    // 2. Create order with calculated total
    $order_id = $orderModel->createOrder(
        session_id(),
        $_POST['order_type'],
        $_POST['total']
    );
    
    // 3. Store items in database before clearing
    $order_details = $orderModel->getOrderDetails($order_id);
    
    // 4. NOW clear cart
    $cartModel->clearCart(session_id());
    
    // 5. Return success with all data
    echo json_encode([
        'success' => true,
        'order_id' => $order_id,
        'order_data' => $order_details,
        'redirect' => "/TKCafe/Views/receipt.php?order_id=$order_id"
    ]);

    } catch (Exception $e) {
        error_log("Order Error: " . $e->getMessage());
        echo json_encode([
            'success' => false,
            'error' => 'Order processing failed. Please try again.'
        ]);
    }
    exit;
} lama*/
?>