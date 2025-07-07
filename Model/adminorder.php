<?php
require_once __DIR__ . '/menu.php';


function getAllOrdersWithItems($conn) {
    $orders = [];
    $menu = new Menu();

    $orderQuery = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");
    if (!$orderQuery) {
        error_log("Order query failed: " . $conn->error);
        return [];
    }

    while ($order = $orderQuery->fetch_assoc()) {
        $stmt = $conn->prepare("SELECT * FROM order_item WHERE order_id = ?");
        $stmt->bind_param("i", $order['id']);
        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            continue;
        }

        $itemsResult = $stmt->get_result();
        $items = $itemsResult->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        foreach ($items as &$item) {
                $menuItem = $menu->getItemById((int)$item['menu_id']); 
            // $menuItem = getItemById($conn, $item['menu_id']);
            if ($menuItem) {
                $item['menu_name'] = $menuItem['name'];
                $item['menu_price'] = is_numeric($menuItem['price']) ? floatval($menuItem['price']) : 0.00;
                $item['menu_description'] = $menuItem['description'];
                $item['menu_category'] = $menuItem['category'];
            } else {
                $item['menu_name'] = 'Unknown Item (ID: ' . $item['menu_id'] . ')';
                $item['menu_price'] = 0.00;
                $item['menu_description'] = '';
                $item['menu_category'] = 'unknown';
            }

            $item['customizations'] = json_decode($item['customizations'] ?? '{}', true);
        }

        $order['items'] = $items;
        $orders[] = $order;
    }

    return $orders;
}

function getOrderById($conn, $id) {
    $menu = new Menu(); 
    $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    $stmt->close();

    if (!$order) return null;

    $stmt = $conn->prepare("SELECT * FROM order_item WHERE order_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $itemsResult = $stmt->get_result();
    $items = $itemsResult->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    foreach ($items as &$item) {
          $menuItem = $menu->getItemById((int)$item['menu_id']); 
        // $menuItem = getItemById($conn, $item['menu_id']);
        if ($menuItem) {
            $item['menu_name'] = $menuItem['name'];
            $item['menu_price'] = is_numeric($menuItem['price']) ? floatval($menuItem['price']) : 0.00;
            $item['menu_description'] = $menuItem['description'];
            $item['menu_category'] = $menuItem['category'];
        } else {
            $item['menu_name'] = 'Unknown Item (ID: ' . $item['menu_id'] . ')';
            $item['menu_price'] = 0.00;
            $item['menu_description'] = '';
            $item['menu_category'] = 'unknown';
        }

        $item['customizations'] = json_decode($item['customizations'] ?? '{}', true);
    }

    $order['items'] = $items;
    $order['total'] = array_sum(array_map(function($item) {
        return $item['menu_price'] * $item['quantity'];
    }, $items));

    return $order;
}

function updateOrderStatus($conn, $orderId, $status) {
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    if (!$stmt) throw new Exception("Prepare failed: " . $conn->error);

    $stmt->bind_param("si", $status, $orderId);
    $success = $stmt->execute();
    $stmt->close();
    return $success;
}
