<?php
// File: /TKCafe/Views/orders_popup.php
if (!isset($order)) {
    echo "No order data.";
    exit;
}

$nextStatus = $order['status'] === 'pending' ? 'preparing' :
              ($order['status'] === 'preparing' ? 'completed' : null);

$buttonLabel = $order['status'] === 'pending' ? 'Preparing' :
               ($order['status'] === 'preparing' ? 'Complete' : null);
?>

<link rel="stylesheet" href="/TKCafe/public/css/admin.css" />

<div class="order-details-container">
    <div class="order-header">
        <div class="order-info">
            <div class="order-status-large">
                <?= strtoupper(htmlspecialchars($order['status'])) ?>
            </div>
            <h1 class="order-title">Order <?= htmlspecialchars($order['order_number']) ?></h1>
        </div>
    </div>
    <!-- <div class="order-meta" style="text-align: left;"> -->
        <div class="order-meta bigger-meta" style="text-align: left; font-size: 1.3rem;">
        <p><strong>Date:</strong> <?= date('M j, Y g:i A', strtotime($order['created_at'])) ?></p>
        <p><strong>Type:</strong> <?= ucfirst(str_replace('_', ' ', $order['order_type'])) ?></p>
        <p><strong>Table:</strong> <?= htmlspecialchars($order['table_name'] ?? 'N/A') ?></p>
        <p><strong>Cutlery:</strong> <?= isset($order['cutlery']) && $order['cutlery'] ? 'Yes' : 'No' ?></p>
    </div>

    <div class="order-items-list">
        <h3>Items:</h3>
        <?php foreach ($order['items'] as $item): ?>
            <div class="order-item">
                <span class="item-line">
                    <?= $item['quantity'] ?>x <?= htmlspecialchars($item['menu_name']) ?>
                </span>

                <?php if (!empty($item['remarks'])&& $item['remarks'] !== 'NULL'): ?>
                    <div class="item-notes">Note: <?= htmlspecialchars($item['remarks']) ?></div>
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

    <div class="order-actions">
        <?php if ($nextStatus): ?>
            <button id="statusBtn"
                    class="btn btn-primary"
                    data-order-id="<?= htmlspecialchars($order['id']) ?>"
                    data-next-status="<?= htmlspecialchars($nextStatus) ?>">
                <?= htmlspecialchars($buttonLabel) ?>
            </button>
        <?php endif; ?>
        <button class="btn btn-outline close-popup close-btn">Close</button>
    </div>
</div>
<script src="/TKCafe/public/js/tabmenu.js"></script>
<script src="/TKCafe/public/js/orders.js"></script>