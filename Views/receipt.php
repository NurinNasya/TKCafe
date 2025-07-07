<?php
session_start();
require_once '../Model/order.php';
require_once '../Model/menu.php';
require_once '../db.php';

$conn = getConnection();
$menuModel = new Menu();
$order_id = $_GET['order_id'] ?? null;

// ✅ Use function instead of object method
$order_data = getOrderDetails($conn, $order_id);

// // Get order data
// $order_data = $orderModel->getOrderDetails($order_id);

// Fallback to session data if needed
// fallback to session
if (empty($order_data) && isset($_SESSION['last_order'])) {
    $order_data = $_SESSION['last_order'];
    unset($_SESSION['last_order']);
}

if (empty($order_data)) {
    http_response_code(404);
    echo "<!DOCTYPE html><html><body><h2>Order not found. Please contact support.</h2></body></html>";
    exit;
}


$order = $order_data['order'];
$items = $order_data['items'] ?? [];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order Receipt - TK Cafe</title>
    <link rel="stylesheet" href="/TKCafe/public/css/style.css">
    <link rel="stylesheet" href="/TKCafe/public/css/receipt.css">
</head>
<body>
    <div class="receipt-container">
        <h1>Order Confirmation</h1>
        <div class="receipt-header">
            <p>Order:<?= htmlspecialchars($order['order_number'] ?? 'N/A') ?></p>
            <p>Date: <?= date('M j, Y H:i', strtotime($order['created_at'])) ?></p>
            <p>Type: <?= ucfirst(str_replace('_', ' ', $order['order_type'])) ?></p>
            <p>Table: <?= htmlspecialchars($order['table_name'] ?? 'N/A') ?></p> <!-- Add this -->
        </div>

        <?php if (empty($items)): ?>
            <div class="alert">No items found in this order</div>
        <?php else: ?>
            <div class="receipt-items">
                <?php foreach ($items as $item): 
                    $menuItem = $menuModel->getItemById($item['menu_id']);
                    if (!$menuItem) continue;
                ?>
                    <div class="receipt-item">
                        <div class="item-info">
                            <h3><?= htmlspecialchars($menuItem['name']) ?></h3>
                            <?php if (!empty($item['remarks'])): ?>
                                <p class="remarks">Note: <?= htmlspecialchars($item['remarks']) ?></p>
                            <?php endif; ?>
                    <!-- <?php if (!empty($item['customizations']) && is_array($item['customizations'])): ?>
                            <p class="customization">
                                Drink: <?= ucwords(str_replace('-', ' ', htmlspecialchars($item['customizations']['drink'] ?? 'Not specified'))) ?>
                            </p>
                            <?php endif; ?> -->

                            <?php if (!empty($item['customizations'])): 
                                $custom = json_decode($item['customizations'], true);
                            ?>
                                <p class="customization">Drink: <?= ucwords(str_replace('-', ' ', $custom['drink'] ?? 'Not specified')) ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="item-price">
                            <span><?= $item['quantity'] ?> × RM <?= number_format((float)$item['price'], 2) ?></span>
                            <!-- <span>RM <?= number_format((float)$item['price'] * $item['quantity'], 2) ?></span> -->
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="receipt-total">
            <div class="total-row">
                <span>Subtotal</span>
                <span>RM <?= number_format($order['total'] / 1.1, 2) ?></span>
            </div>
            <div class="total-row">
                <span>Service Charge (10%)</span>
                <span>RM <?= number_format($order['total'] * 0.1, 2) ?></span>
            </div>
            <div class="total-row grand-total">
                <span>Total</span>
                <span>RM <?= number_format($order['total'], 2) ?></span>
            </div>
        </div>

        <div class="receipt-footer">
            <p>Thank you for your order!</p>
            <a href="/TKCafe/Views/menu.php" class="btn">Back to Menu</a>
        </div>
    </div>
</body>
</html>
