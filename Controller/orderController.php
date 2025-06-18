<?php
session_start();
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
}




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
}*/
?>