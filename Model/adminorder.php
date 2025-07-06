<?php
// File: /TKCafe/Model/adminorder.php
require_once __DIR__ . '/menu.php';

class AdminOrderModel {
    private $db;
    private $menuModel;

    public function __construct($db) {
        $this->db = $db;
        $this->menuModel = new Menu();
    }

    public function getAllOrdersWithItems() {
        $orders = [];
        
        // // Get all orders
        // $orderQuery = $this->db->query("
        //     SELECT o.*, t.table_name 
        //     FROM orders o 
        //     LEFT JOIN tables t ON o.table_id = t.id 
        //     ORDER BY o.created_at DESC
        // ");

        $orderQuery = $this->db->query("SELECT * FROM orders ORDER BY created_at DESC");
        if (!$orderQuery) {
            error_log("Order query failed: " . $this->db->error);
            return [];
        }

        while ($order = $orderQuery->fetch_assoc()) {
            // Get items for each order
            $stmt = $this->db->prepare("
                SELECT oi.* 
                FROM order_item oi 
                WHERE oi.order_id = ?
            ");
            $stmt->bind_param("i", $order['id']);
            // $stmt = $this->db->prepare("
            //     SELECT oi.* 
            //     FROM order_item oi 
            //     WHERE oi.session_id = ?
            // ");
            
            // if (!$stmt) {
            //     error_log("Prepare failed: " . $this->db->error);
            //     continue;
            // }

            // $stmt->bind_param("s", $order['session_id']);
            if (!$stmt->execute()) {
                error_log("Execute failed: " . $stmt->error);
                continue;
            }

            $itemsResult = $stmt->get_result();
            $items = $itemsResult->fetch_all(MYSQLI_ASSOC);
            
            // Add menu information to each item
            foreach ($items as &$item) {
                $menuItem = $this->menuModel->getItemById($item['menu_id']);
                if ($menuItem) {
                    $item['menu_name'] = $menuItem['name'];
                    $item['menu_price'] = $menuItem['price'];
                    $item['menu_description'] = $menuItem['description'];
                    $item['menu_category'] = $menuItem['category'];
                } else {
                    $item['menu_name'] = 'Unknown Item (ID: ' . $item['menu_id'] . ')';
                    $item['menu_price'] = 0.00;
                    $item['menu_description'] = '';
                    $item['menu_category'] = 'unknown';
                }
                   // ✅ Make sure it's not NULL and always set
                   $item['customizations'] = json_decode($item['customizations'] ?? '{}', true);
            // $item['customizations'] = $item['customizations'] ?? '{}';
            }

            $order['items'] = $items;
            $orders[] = $order;
        }
        
        return $orders;
    }

   public function getOrderById($id) {
    $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    $stmt->close();

    if (!$order) return null;

    // Get items
    $stmt = $this->db->prepare("SELECT * FROM order_item WHERE order_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $itemsResult = $stmt->get_result();
    $items = $itemsResult->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Add menu details using Menu model
    foreach ($items as &$item) {
        $menuItem = $this->menuModel->getItemById($item['menu_id']);
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

    // Calculate total
    $order['items'] = $items;
    $order['total'] = array_sum(array_map(function($item) {
        return $item['menu_price'] * $item['quantity'];
    }, $items));

    return $order;
}

public function updateStatus($orderId, $status) {
    $stmt = $this->db->prepare("UPDATE orders SET status = ? WHERE id = ?");
    if (!$stmt) throw new Exception("Prepare failed: " . $this->db->error);

    $stmt->bind_param("si", $status, $orderId);
    $success = $stmt->execute();
    $stmt->close();
    return $success;
}

}