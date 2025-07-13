<?php

function generateOrderNumber($conn) {
    $query = "SELECT MAX(id) AS last_id FROM orders";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $nextId = isset($row['last_id']) ? $row['last_id'] + 1 : 1;

    return '#' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
}

// function createInitialOrder($conn, $sessionId, $orderType) {
function createInitialOrder($conn, $sessionId, $orderType, $tableId) {
    $orderNumber = generateOrderNumber($conn);
    $tableId = intval($tableId); // ensure it's an integer

    $sessionId = mysqli_real_escape_string($conn, $sessionId);
    $orderType = mysqli_real_escape_string($conn, $orderType);

    $query = "
    INSERT INTO orders (order_number, session_id, order_type, status, table_id)
    VALUES ('$orderNumber', '$sessionId', '$orderType', 'pending', $tableId)
    ";
    
    // $query = "
    //     INSERT INTO orders (order_number, session_id, order_type, status)
    //     VALUES ('$orderNumber', '$sessionId', '$orderType', 'pending')
    // ";
    
    if (!mysqli_query($conn, $query)) {
        throw new Exception("Order creation failed: " . mysqli_error($conn));
    }

    return mysqli_insert_id($conn);
}

function getCurrentOrderBySession($conn, $sessionId) {
    $sessionId = mysqli_real_escape_string($conn, $sessionId);

    $query = "
        SELECT * FROM orders 
        WHERE session_id = '$sessionId' 
        AND status = 'pending'
        ORDER BY created_at DESC 
        LIMIT 1
    ";

    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

function updateOrderType($conn, $sessionId, $orderType) {
    $sessionId = mysqli_real_escape_string($conn, $sessionId);
    $orderType = mysqli_real_escape_string($conn, $orderType);

    $query = "
        UPDATE orders 
        SET order_type = '$orderType', updated_at = CURRENT_TIMESTAMP 
        WHERE session_id = '$sessionId' AND status = 'pending'
        ORDER BY created_at DESC 
        LIMIT 1
    ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn) > 0;
}

function updateOrderTotals($conn, $orderId, $total, $items,  $cutlery = 0) {
    mysqli_begin_transaction($conn);

    try {
        // 1. Delete existing items
        $orderId = intval($orderId);
        mysqli_query($conn, "DELETE FROM order_item WHERE order_id = $orderId");

        // 2. Insert all items
        foreach ($items as $item) {
            $menuId      = intval($item['menu_id']);
            $quantity    = intval($item['quantity']);
            $price       = floatval($item['price']);
            $sessionId = mysqli_real_escape_string($conn, session_id());
            // $sessionId   = mysqli_real_escape_string($conn, $item['session_id']);
            $custom      = !empty($item['customizations']) ? "'" . mysqli_real_escape_string($conn, json_encode($item['customizations'])) . "'" : "NULL";
            $remarks     = isset($item['remarks']) ? "'" . mysqli_real_escape_string($conn, $item['remarks']) . "'" : "NULL";

            $query = "
                INSERT INTO order_item (order_id, menu_id, quantity, price, session_id, customizations, remarks)
                VALUES ($orderId, $menuId, $quantity, $price, '$sessionId', $custom, $remarks)
            ";

            mysqli_query($conn, $query);
        }

        // 3. Update total
        $total = floatval($total);
        $query = "
            UPDATE orders 
            SET total = $total, cutlery = $cutlery, status = 'pending', updated_at = NOW()
            WHERE id = $orderId
        ";
        mysqli_query($conn, $query);

        mysqli_commit($conn);
        return true;

    } catch (Exception $e) {
        mysqli_rollback($conn);
        error_log("Order update failed: " . $e->getMessage());
        throw $e;
    }
}

function getOrderDetails($conn, $orderId) {
    $orderId = intval($orderId);

    // 1. Get order info
    $query = "
        SELECT o.*, t.table_name 
        FROM orders o 
        LEFT JOIN tables t ON o.table_id = t.id 
        WHERE o.id = $orderId
    ";
    $result = mysqli_query($conn, $query);
    $order = mysqli_fetch_assoc($result);
    if (!$order) return null;

    // 2. Get items
    $itemQuery = "
        SELECT menu_id, quantity, price, customizations, remarks 
        FROM order_item 
        WHERE order_id = $orderId
    ";
    $result = mysqli_query($conn, $itemQuery);

    $items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $row['customizations'] = !empty($row['customizations']) ? json_decode($row['customizations'], true) : null;
        $items[] = $row;
    }

    return [
        'order' => $order,
        'items' => $items
    ];
}

// function clearOrderCart($conn, $sessionId) {
//     $sessionId = mysqli_real_escape_string($conn, $sessionId);

//     $query = "DELETE FROM order_item WHERE session_id = '$sessionId'";
//     mysqli_query($conn, $query);

//     return mysqli_affected_rows($conn);
// }
