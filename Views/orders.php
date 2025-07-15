<?php
// File: /TKCafe/Views/orders.php

session_start();
require_once '../Model/adminorder.php';
require_once '../db.php';

$conn = getConnection(); 
// Include controller

try {
   $orders = getAllOrdersWithItems($conn);
    
    if (!is_array($orders)) {
        throw new RuntimeException('No orders data received');
    }
} catch (Exception $e) {
    die('<div class="error">' . htmlspecialchars($e->getMessage()) . '</div>');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - TK Cafe Admin</title>
    <link rel="stylesheet" href="/TKCafe/public/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <?php include __DIR__ . '/partials/sidebar.php'; ?>
        
        <main class="main-content">
            <h1>All Orders</h1>
            
            <?php if (empty($orders)): ?>
                <p class="no-orders">No orders found</p>
            <?php else: ?>
                <div class="order-grid">
                    <?php foreach ($orders as $order): ?>
                 <div class="order-card" data-order-id="<?= $order['id'] ?>">

                        <div class="order-header">
                            <span class="order-id"><?= htmlspecialchars($order['order_number']) ?></span>
                                <span class="order-meta">
                                    <?= ucfirst(str_replace('_', ' ', $order['order_type'])) ?> | 
                                    <span class="order-status status-<?= strtolower($order['status']) ?>">
                                        <?= htmlspecialchars($order['status']) ?>
                                    </span>
                            <!-- <span class="order-status status-<?= strtolower($order['status']) ?>">
                                <?= htmlspecialchars($order['status']) ?> -->
                            </span>
                        </div>
                        
                        <div class="order-details">
                            <!-- <p>Customer: <?= htmlspecialchars($order['customer_name'] ?? 'N/A') ?></p> -->
                            <p>Date: <?= date('M j, Y g:i A', strtotime($order['created_at'])) ?></p>
                            <!-- <p>Type: <?= ucfirst(str_replace('_', ' ', $order['order_type'])) ?></p> -->
                            <p>Table: <?= htmlspecialchars($order['table_name'] ?? 'N/A') ?></p> <!-- Add this -->
                            <?php if (isset($order['cutlery'])): ?>
                            <p>Cutlery: <?= $order['cutlery'] ? 'Yes' : 'No' ?></p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="order-items">
                            <?php foreach ($order['items'] as $item): ?>
                            <div class="item">
                                <span class="quantity"><?= $item['quantity'] ?>x</span>
                                <span class="name"><?= htmlspecialchars($item['menu_name']) ?></span>
                                <?php if (!empty($item['remarks'])): ?>
                                <div class="notes">Note: <?= htmlspecialchars($item['remarks']) ?></div>
                                <?php endif; ?>
                            <?php 
                            $custom = is_string($item['customizations']) 
                                ? json_decode($item['customizations'], true) 
                                : (is_array($item['customizations']) ? $item['customizations'] : []);

                            $drink = isset($custom['drink']) ? $custom['drink'] : null;

                            if ($drink):
                            ?>
                            <div class="notes">Drink: <?= ucwords(str_replace('-', ' ', htmlspecialchars($drink))) ?></div>
                            <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="order-footer">
                            <div class="order-actions">
                              <button class="btn btn-sm btn-outline view-btn">View</button>

                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- At the bottom of orders.php -->
<div id="overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999;"></div>
<div id="popup" style="display:none; position:fixed; top:20%; left:50%; transform:translateX(-50%); background:#fff; padding:20px; border:1px solid #ccc; z-index:1000; max-width:700px; width:90%;"></div>

<script src="/TKCafe/public/js/orders.js"></script>

</body>
</html>

