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
    <div class="order-meta-popup">
    <p><strong>Date:</strong> <?= date('M j, Y g:i A', strtotime($order['created_at'])) ?></p>
    <p><strong>Type:</strong> <?= ucfirst(str_replace('_', ' ', $order['order_type'])) ?></p>
    <p><strong>Table:</strong> <?= htmlspecialchars($order['table_name'] ?? 'N/A') ?></p>
    </div>
<!-- 
    <div class="order-meta">
        <p><strong>Date:</strong> <?= date('M j, Y g:i A', strtotime($order['created_at'])) ?></p>
        <p><strong>Type:</strong> <?= ucfirst(str_replace('_', ' ', $order['order_type'])) ?></p>
         <p>Table: <?= htmlspecialchars($order['table_name'] ?? 'N/A') ?></p>
    </div> -->

    <div class="order-items-list">
        <h3>Items:</h3>
        <?php foreach ($order['items'] as $item): ?>
        <div class="order-item">
              <span class="item-line">
                <?= $item['quantity'] ?>x <?= htmlspecialchars($item['menu_name']) ?>
            </span>
            <?php if (!empty($item['remarks'])): ?>
            <div class="item-notes">Note: <?= htmlspecialchars($item['remarks']) ?></div>
            <?php endif; ?>
             <?php 
            $drink = is_array($item['customizations']) ? ($item['customizations']['drink'] ?? null) : null;
            if ($drink):
        
        ?>
            <!-- <div class="item-notes">Drink: <?= ucwords(str_replace('-', ' ', htmlspecialchars($custom['drink']))) ?></div> -->
             <!-- <div class="notes">Drink: <?= ucwords(str_replace('-', ' ', htmlspecialchars($item['customizations']['drink']))) ?></div> -->
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
        <!-- <button id="completeBtn" class="btn btn-primary" data-order-id="<?= $order['order_id'] ?>">
            Mark as Completed
        </button> -->
        <button class="btn btn-outline close-popup">Close</button>
    </div>
</div>

